<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    
    require_once "../components/server-functions.php";
    
    // Redirect the user to the dashboard
    if (isset($_SESSION["user"])) {
      header("Location: " . generateUrl("/pages/" . strtolower($_SESSION["user"]["permission"]) . ".php"));
      exit();
    
    // If the user does not have a session
    } else {
      header("Location: " . generateUrl("logged-out.php"));
      exit();
    }
?>