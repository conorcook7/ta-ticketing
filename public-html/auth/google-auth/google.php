<?php
    session_start();

    require_once "../google-api-php-client-2.2.2_PHP54/vendor/autoload.php";
    require_once "../../components/KLogger.php";
    require_once "../../components/dao.php";
    require_once "../../components/server-functions.php";

    $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);

    // Step 1: Set up the google client
    $googleClient = new Google_Client();
    $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
    $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
    $googleClient->setRedirectUri(generateUrl("/auth/google-auth/google.php"));
    $googleClient->setScopes("email profile");

    $logger->logDebug(__FUNCTION__ . ": Google client created");

    // Step 2: Create the authorization url
    $authUrl = $googleClient->createAuthUrl();
    $logger->logDebug(__FUNCTION__ . ": Google authorization url created");

    // Step 3: Get the authorization code
    if (!isset($_GET["code"])) {
        $logger->logDebug(__FUNCTION__ . ": Google access code not set");
        header("Location: " . $authUrl);
        exit();
    } else {
        $logger->logDebug(__FUNCTION__ . ": Google access code set");
    }
    $authCode = isset($_GET["code"]) ? $_GET["code"] : NULL;
    
    // Step 4: Get access token
    if (isset($authCode)) {

        try {
            $accessToken = $googleClient->fetchAccessTokenWithAuthCode($authCode);
            $googleClient->setAccessToken($accessToken);
            $logger->logDebug(__FUNCTION__ . ": Google access token received");

        } catch (Exception $e) {
            $logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            header("Location: ./google.php");
            exit();
        }

        try {
            // Set the timezone to Mountain Time (Boise, ID)
            date_default_timezone_set("America/Boise");
            $logger->logDebug(__FUNCTION__ . ": Set time zone to Mountain Time");

            // Verify the google client
            $payload = $googleClient->verifyIdToken();
            $logger->logDebug(__FUNCTION__ . ": Google client was verified");

            if (isset($payload)) {
                // Setup session from payload
                $logger->logDebug(__FUNCTION__ . ": Google OAuth payload contains data");

                // Check payload email for boisestate
                $splitEmail = explode("@", $payload["email"]);
                $emailDomain = $splitEmail[1];
                if ($emailDomain != "u.boisestate.edu" && $emailDomain != "boisestate.edu") {
                    header("Location: ./google.php");
                    exit();
                }

                // Setup session from payload
                $_SESSION["user"]["email"] = $payload["email"];
                $_SESSION["user"]["given_name"] = $payload["given_name"];
                $_SESSION["user"]["family_name"] = $payload["family_name"];
                $_SESSION["user"]["name"] = $payload["name"];
                $_SESSION["user"]["picture"] = $payload["picture"];
                $_SESSION["user"]["accessToken"] = $accessToken;

                // Database setup for user
                $dao = new Dao();

                // If the user is not in the database
                if (!$dao->userExists($_SESSION["user"]["email"])) {
                    $querySuccessful = $dao->createUser(
                        $_SESSION["user"]["email"],
                        $_SESSION["user"]["given_name"],
                        $_SESSION["user"]["family_name"]
                    );
                    if (!$querySuccessful) {
                        $logger->logError(__FUNCTION__ . ": Unable to create user with dao method.");
                        header("Location: ./google.php");
                        exit();
                    }
                }
                
                // Set the user to online
                $count = 0;
                while (!$dao->setUserOnline($_SESSION["user"]["email"]) && $count < 5) {
                    $logger->logError(__FUNCTION__ . ": Unable to set the user to online with dao method.");
                    $count++;
                }

                // Redirect if the user could not be set to online
                if ($count == 5) {
                    header("Location: ./google.php");
                    exit();
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
                $_SESSION["user"]["online"] = TRUE;

                // Redirect to the dashboard
                header("Location: ../../pages/" . strtolower($_SESSION["user"]["permission"]) . ".php");
                exit();
            }

        } catch (Exception $e) {
            $logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            header("Location: ./google.php");
            exit();
        }

    }

    header("Location: ./google.php");
    exit();