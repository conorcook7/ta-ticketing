<?php
    session_start();

    require_once "../google-api-php-client-2.2.2_PHP54/vendor/autoload.php";
    require_once "../../components/KLogger.php";

    // Step 1: Set up the google client
    $googleClient = new Google_Client();
    $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
    $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
    $googleClient->setRedirectUri("http://taticketing.boisestate.edu/auth/google-auth/google.php");
    $googleClient->setScopes("email profile");

    // Step 2: Create the authorization url
    $authUrl = $googleClient->createAuthUrl();

    // Step 3: Get the authorization code
    if (!isset($_GET["code"])) {
        header("Location: " . $authUrl);
        exit();
    }
    $authCode = isset($_GET["code"]) ? $_GET["code"] : NULL;
    
    // Step 4: Get access token
    if (isset($authCode)) {

        try {
            $accessToken = $googleClient->fetchAccessTokenWithAuthCode($authCode);
            $googleClient->setAccessToken($accessToken);

        } catch (Exception $e) {
            echo "Access Token Error: ";
            echo $e->getMessage();
        }

        try {
            date_default_timezone_set("America/Boise");
            $payload = $googleClient->verifyIdToken();

            if (isset($payload)) {
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
            echo "Payload Error: ";
            echo $e->getMessage();
        }

    } else {
        $payload = NULL;
    }