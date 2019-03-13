<?php
    session_start();

    require_once "../google-api-php-client-2.2.2_PHP54/vendor/autoload.php";
    require_once "../../components/KLogger.php";

    $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);

    // Step 1: Set up the google client
    $googleClient = new Google_Client();
    $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
    $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
    $googleClient->setRedirectUri("http://taticketing.boisestate.edu/auth/google-auth/google.php");
    $googleClient->setScopes("email profile");

    $logger->logDebug("Google client created");

    // Step 2: Create the authorization url
    $authUrl = $googleClient->createAuthUrl();
    $logger->logDebug("Google authorization url created");

    // Step 3: Get the authorization code
    if (!isset($_GET["code"])) {
        $logger->logDebug("Google access code not set");
        header("Location: " . $authUrl);
        exit();
    } else {
        $logger->logDebug("Google access code set");
    }
    $authCode = isset($_GET["code"]) ? $_GET["code"] : NULL;
    
    // Step 4: Get access token
    if (isset($authCode)) {

        try {
            $accessToken = $googleClient->fetchAccessTokenWithAuthCode($authCode);
            $googleClient->setAccessToken($accessToken);
            $logger->logDebug("Google access token received");

        } catch (Exception $e) {
            $logger->logError($e->getMessage());
            header("Location: ./google.php");
            exit();
        }

        try {
            // Set the timezone to Mountain Time (Boise, ID)
            date_default_timezone_set("America/Boise");
            $logger->logDebug("Set time zone to Mountain Time");

            // Verify the google client
            $payload = $googleClient->verifyIdToken();
            $logger->logDebug("Google client was verified");

            if (isset($payload)) {
                $logger->logDebug("Google OAuth payload contains data");
                $_SESSION["user"]["email"] = $payload["email"];
                $_SESSION["user"]["givenName"] = $payload["given_name"];
                $_SESSION["user"]["familyName"] = $payload["family_name"];
                $_SESSION["user"]["name"] = $payload["name"];
                $_SESSION["user"]["picture"] = $payload["picture"];
                $_SESSION["user"]["accessToken"] = $accessToken;

                // Redirect to the dashboard
                header("Location: ../../pages/index.php");
            }

        } catch (Exception $e) {
            $logger->logError($e->getMessage());
            header("Location: ./google.php");
            exit();
        }

    }

    header("Location: ./google.php");
    exit();