<?php

    require "../google-api-php-client-2.2.2_PHP54/vendor/autoload.php";

    // Step 1: Set up the google client
    $googleClient = new Google_Client();
    $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
    $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
    $googleClient->setRedirectUri("http://taticketing.boisestate.edu/auth/google-auth/google.php");
    $googleClient->setScopes("email profile");

    // Step 2: Create the authorization url
    $authUrl = $googleClient->createAuthUrl();
    echo "<a href='$authUrl'>Google Sign In</a>";

    // Step 3: Get the authorization code
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
            
            // Step 5: If payload is set then redirect to index.php, else redirect to login.
            echo "<pre>" . print_r($payload, 1) . "</pre>";

        } catch (Exception $e) {
            echo "Payload Error: ";
            echo $e->getMessage();
        }

    } else {
        $payload = NULL;
    }