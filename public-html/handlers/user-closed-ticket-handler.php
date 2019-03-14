<?php
    session_start();
    require_once "../components/dao.php";
    require_once "../components/KLogger.php";

    $dao = new Dao("Dummy_TA_Ticketing");

    if (isset($_POST["closed_ticket_id"]) && isset($_SESSION["user"]["user_id"])) {
        $status = $dao->openClosedTicket($_POST["closed_ticket_id"], $_SESSION["user"]["user_id"]);
    } else {
        $status = 0;
    }
    
    if (!$status) {
        $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
        $logger->logError(__FILE__ . ": Unable to delete closed ticket {" . $_POST["closed_ticket_id"] . "}");
    }

    header("Location: ../pages/user.php");
    exit();