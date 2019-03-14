<?php
    session_start();
    require_once "../components/dao.php";
    require_once "../components/KLogger";
    
    //$dao = new Dao("Dummy_TA_Ticketing");

    // if (isset($_POST["open_ticket_id"]) && isset($_SESSION["user"]["user_id"])) {
    //     $status = $dao->closeTicket($_POST["open_ticket_id"], $_SESSION["user"]["user_id"]);
    // } else {
    //     $status = 0;
    // }
    
    // if (!$status) {
    //     $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
    //     $logger->logError(__FILE__ . ": Unable to delete open ticket {" . $_POST["open_ticket_id"] . "}");
    // }

    header("Location: ../pages/user.php");
    exit();