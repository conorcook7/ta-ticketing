<?php
    require_once "../auth/google-api-php-client-2.2.2_PHP54/vendor/autoload.php";
    require_once "../components/dao.php";
    require_once "../components/KLogger.php";

    session_start();

    $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);

    // Revoke Google OAuth
    $googleClient = new Google_Client();
    $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
    $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
    $googleClient->setRedirectUri("http://taticketing.boisestate.edu/auth/google-auth/google.php");
    $googleClient->setScopes("email profile");
    $googleClient->setAccessToken($_SESSION["user"]["accessToken"]);
    $googleClient->revokeToken();

    // Set the user to offline
    $dao = new Dao("Dummy_TA_Ticketing");
    try {
        $count = 0;
        while (!$dao->setUserOffline($_SESSION["user"]["email"]) && $count < 5) {
            $count++;
        }
        
        if ($count >= 5) {
            $logger->logError("Unable to set user to offline");
        }

    } catch (Exception $e) {
        $logger->logError($e->getMessage());
    }

    // Unset the user
    unset($_SESSION["user"]);
    session_destroy();

    // Redirect to the login page
    header("Location: ../auth/google-auth/google.php");
    exit();
?>