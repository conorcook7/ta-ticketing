<?php
    session_start();

    require_once "../google-api-php-client-2.2.2_PHP54/vendor/autoload.php";
    require_once "../../components/dao.php";
    require_once "../../components/server-functions.php";

    $logger = getServerLogger();    // Get the KLogger object

    // Store the local IP address
    if (isset($_POST["local_ip"])) {
        $logger->logDebug("Setting local ip");
        $_SESSION["local_ip"] = isset($_POST["local_ip"]) ? $_POST["local_ip"] : "";
        unset($_POST["local_ip"]);
    }

    // Step 1: Set up the google client
    $googleClient = new Google_Client();
    $googleClient->setClientId("479242747472-coohl2sguq463l7rlvpitp8hijsmm5cc.apps.googleusercontent.com");
    $googleClient->setClientSecret("Yz1FgBF9oTfyQFq3woL6_abY");
    $googleClient->setRedirectUri(generateUrl("/auth/google-auth/google.php"));
    $googleClient->setScopes("email profile");

    $logger->logDebug(basename(__FILE__) . ": Google client created");

    // Step 2: Create the authorization url
    $authUrl = $googleClient->createAuthUrl();
    $logger->logDebug(basename(__FILE__) . ": Google authorization url created");

    // Step 3: Get the authorization code
    if (!isset($_GET["code"])) {
        $logger->logDebug(basename(__FILE__) . ": Google access code not set");
        header("Location: " . $authUrl);
        exit();
    } else {
        $logger->logDebug(basename(__FILE__) . ": Google access code set");
    }
    $authCode = isset($_GET["code"]) ? $_GET["code"] : NULL;
    
    // Step 4: Get access token
    if (isset($authCode)) {

        try {
            $accessToken = $googleClient->fetchAccessTokenWithAuthCode($authCode);
            $googleClient->setAccessToken($accessToken);
            $logger->logDebug(basename(__FILE__) . ": Google access token received");

        } catch (Exception $e) {
            $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
            $_SESSION["login-error"] = "Unable to find Google account.";
            header("Location: " . generateUrl("/handlers/logout-handler.php"));
            exit();
        }

        try {
            // Set the timezone to Mountain Time (Boise, ID)
            date_default_timezone_set("America/Boise");
            $logger->logDebug(basename(__FILE__) . ": Set time zone to Mountain Time");

            // Verify the google client
            $payload = $googleClient->verifyIdToken();
            $logger->logDebug(basename(__FILE__) . ": Google client was verified");

            if (isset($payload)) {
                // Setup session from payload
                $logger->logDebug(basename(__FILE__) . ": Google OAuth payload contains data");

                // Check payload email for boisestate
                $splitEmail = explode("@", $payload["email"]);
                $emailDomain = $splitEmail[1];
                if ($emailDomain != "u.boisestate.edu" && $emailDomain != "boisestate.edu") {
                    $_SESSION["login-error"] = "You must use a <strong class='text-gray-800'>Boise State</strong> email address. If this is a mistake you may contact the system administrator.";
                    header("Location: " . generateUrl("/handlers/logout-handler.php"));
                    exit();
                }

                // Setup session from payload
                $_SESSION["user"]["email"] = $payload["email"];
                $_SESSION["user"]["given_name"] = $payload["given_name"];
                $_SESSION["user"]["family_name"] = $payload["family_name"];
                $_SESSION["user"]["name"] = $payload["name"];
                $_SESSION["user"]["picture"] = $payload["picture"];
                $_SESSION["user"]["accessToken"] = $accessToken;

                // Get a dao object
                $dao = new Dao();

                // If the user is not in the database
                if (!$dao->userExists($_SESSION["user"]["email"])) {
                    $querySuccessful = $dao->createUser(
                        $_SESSION["user"]["email"],
                        $_SESSION["user"]["given_name"],
                        $_SESSION["user"]["family_name"]
                    );
                    if (!$querySuccessful) {
                        $logger->logError(basename(__FILE__) . ": Unable to create user with dao method.");
                        $_SESSION["login-error"] = "Unable to get your account. Please try again later.";
                        header("Location: " . generateUrl("/handlers/logout-handler.php"));
                        exit();
                    }
                }
                
                // Set the user to online
                $status = $dao->setUserOnline($_SESSION["user"]["email"]);
                if (!$status) {
                    $logger->logError(__FILE__ . ": unable to set user online");
                }

                // Get user information
                $user = $dao->getUser($_SESSION["user"]["email"]);
                $_SESSION["user"]["user_id"] = $user["user_id"];
                $_SESSION["user"]["permission"] = $user["permission_name"];
                $_SESSION["user"]["access_level"] = $user["permission_id"];
                $_SESSION["user"]["online_since"] = new DateTime(
                    $user["update_date"],
                    new DateTimeZone("America/Boise")
                );

                // Set the user to online
                $_SESSION["user"]["online"] = "ONLINE";
                
                // Set the users computer name
                $localIP = isset($_SESSION["local_ip"]) ? $_SESSION["local_ip"] : "";
                $logger->logDebug(basename(__FILE__) . ": local IP: " . $localIP);
                $_SESSION["user"]["computer_name"] = getComputerName($localIP);

                // Check if the user is blacklisted
                if ($dao->isBlacklisted($_SESSION["user"]["email"])) {
                    $logger->logWarn(basename(__FILE__) . ": Blacklisted user is attempting to access the website.");
                    $_SESSION["login-error"] = "You do not have permission to access the website. If this is a mistake, please contact the system administrator.";
                    header("Location: " . generateUrl("/handlers/logout-handler.php"));
                    exit();
                }

                // Redirect to the dashboard - Everything is OK
                header("Location: ../../pages/" . strtolower($_SESSION["user"]["permission"]) . ".php");
                exit();
            }

        } catch (Exception $e) {
            $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
            $_SESSION["login-error"] = "Unable to get your account. Please try again later.";
            header("Location: " . generateUrl("/handlers/logout-handler.php"));
            exit();
        }

    }

    $_SESSION["login-error"] = "Unable to authenticate your account. Please try again later.";
    header("Location: " . generateUrl("/handlers/logout-handler.php"));
    exit();