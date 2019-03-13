<?php
    require_once "../auth/google-api-php-client-2.2.2_PHP54/vendor/autoload.php";

    session_start();

    // Revoke Google OAuth
    $googleClient = new Google_Client();
    $googleClient->setClientId("153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com");
    $googleClient->setClientSecret("ZyXV3mVUVs89rDkuq8RjFaH4");
    $googleClient->setRedirectUri("http://taticketing.boisestate.edu/auth/google-auth/google.php");
    $googleClient->setScopes("email profile");
    $googleClient->setAccessToken($_SESSION["user"]["accessToken"]);
    $googleClient->revokeToken();

    // Unset the user
    unset($_SESSION["user"]);
    session_destroy();

    // Redirect to the login page
    header("Location: ../auth/google-auth/google.php");
    exit();
?>