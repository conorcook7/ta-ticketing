<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    $dao = new Dao();

    if (isset($_POST["closed_ticket_id"]) && isset($_SESSION["user"]["user_id"])) {
        
        // Check if the person reopening the ticket is the person who created it
        $creatorUserId = isset($_POST["student_user_id"]) ? $_POST["student_user_id"] : -1;
        if (($_SESSION["user"]["user_id"] == $creatorUserId) && isset($_SESSION["user"]["computer_name"])) {
            $status = $dao->openClosedTicket($_POST["closed_ticket_id"], $_SESSION["user"]["user_id"], $_SESSION["user"]["computer_name"]);

        // Regular reopen
        } else {
            $status = $dao->openClosedTicket($_POST["closed_ticket_id"], $_SESSION["user"]["user_id"]);
        }
    } else {
        $status = 0;
    }

    unset($_POST);
    
    if (!$status) {
        $logger = getServerLogger();
        $logger->logError(__FILE__ . ": Unable to reopen closed ticket {" . $_POST["closed_ticket_id"] . "}");
        $_SESSION['failure'] = 'Unable to reopen ticket';
    } else {
        $_SESSION['success'] = 'Reopened ticket';
    }
    header("Location: ../pages/user.php");
    exit();