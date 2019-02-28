<?php

    require_once "config.php";

    unset($_SESSION["access_token"]);
    $client->revokeToken();
    header("Location: login.php");
    exit();