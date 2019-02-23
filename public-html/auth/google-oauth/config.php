<?php

require_once __DIR__.'/../../vendor/autoload.php';

    $clientId = "153288048540-sogdggkb32ugai855a0uffo0d7h2hqnq.apps.googleusercontent.com";
    $clientSecret = "ZyXV3mVUVs89rDkuq8RjFaH4";
    
    session_start();

    // Generate client
    $client = new Google_Client();
    $client->setApplicationName('TA Ticketing');
    $client->setClientId($clientId);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri('http://localhost:8080/auth/google-oauth/google-callback.php');
    $client->addScope('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email');