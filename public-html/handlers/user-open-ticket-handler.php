<?php
    session_start();
    require_once "../components/dao.php";
    require_once "../components/KLogger"

    $dao = new Dao("Dummy_TA_Ticketing");
    $status = $dao->closeTicket($_POST["open_ticket_id"], $_SESSION["user"]["user_id"]);
    
    if ($status) {
        header("Location: ../pages/user.php");
        exit();

    } else {
        $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
        $logger->logError(__FILE__ . ": Unable to delete open ticket {" . $_POST["open_ticket_id"] . "}");
        header("Location: ../pages/user.php");
        exit();
    }