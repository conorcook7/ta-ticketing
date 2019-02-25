<?php

    require_once "config.php";

    // if (isset($_SESSION["access_token"])) {
    //     $client->setAccessToken($_SESSION["access_token"]);

    // } else if (isset($_GET["code"])) {
    //     $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
    //     $_SESSION["access_token"] = $token;

    // } else {
    //     header("Location: ../../pages/google-index.php");
    //     exit();
    // }



    if (isset($_GET["code"])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
        $_SESSION["access_token"] = $token;
    }


    // Store user data in the session.
    $google_oauth = new \Google_Service_Oauth2($client);
    $userData = $google_oauth->userinfo_v2_me->get();
    // $_SESSION['user']['id'] = $userData['id'];
    // $_SESSION['user']['email'] = $userData['email'];
    // $_SESSION['user']['familyName'] = $userData['familyName'];
    // $_SESSION['user']['givenName'] = $userData['givenName'];
    // $_SESSION['user']['picture'] = $userData['picture'];
    // $_SESSION['user']['gender'] = $userData['gender'];

    echo "<pre>" . print_r($userData, 1) . "</pre>"; 

    // Redirect the user to index page.
    // header("Location: ../../pages/google-index.php");
    // exit();
