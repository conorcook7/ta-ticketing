<?php
    session_start();
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    $dao = new Dao();

    if (isset($_POST["closed_ticket_id"]) && isset($_SESSION["user"]["user_id"])) {
        $status = $dao->openClosedTicket($_POST["closed_ticket_id"], $_SESSION["user"]["user_id"]);
    } else {
        $status = 0;
    }

    unset($_POST);
    
    if (!$status) {
        $logger = getServerLogger();
        $logger->logError(__FILE__ . ": Unable to delete closed ticket {" . $_POST["closed_ticket_id"] . "}");
    }

    header("Location: ../pages/user.php");
    exit();