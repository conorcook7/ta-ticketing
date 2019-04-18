<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once "../auth/google-api-php-client-2.2.2_PHP54/vendor/autoload.php";
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    session_start();

    $logger = getServerLogger();

    if (isset($_SESSION["user"]["accessToken"])) {
        // Revoke Google OAuth
        $googleClient = new Google_Client();
        $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
        $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
        $googleClient->setRedirectUri(generateUrl("/auth/google-auth/google.php"));
        $googleClient->setScopes("email profile");
        $googleClient->setAccessToken($_SESSION["user"]["accessToken"]);
        $googleClient->revokeToken();

        // Set the user to offline
        $dao = new Dao();
        try {
            $status = $dao->setUserOffline($_SESSION["user"]["email"]);
            if (!$status) {
                $logger->logError("Unable to set user to offline");
            }

        } catch (Exception $e) {
            $logger->logError($e->getMessage());
        }
    }

    // Unset the user
    unset($_SESSION["user"]);

    // Redirect to the login page
    header("Location: ../pages/logged-out.php");
    exit();
?>