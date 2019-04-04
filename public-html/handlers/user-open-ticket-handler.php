<?php
    session_start();
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    $dao = new Dao();

    if (isset($_POST["open_ticket_id"]) && isset($_SESSION["user"]["user_id"])) {
        $status = $dao->closeTicket($_POST["open_ticket_id"], $_SESSION["user"]["user_id"]);
    } else {
        $status = 0;
    }
    
    if (!$status) {
        $logger = getServerLogger();
        $logger->logError(__FILE__ . ": Unable to delete open ticket {" . $_POST["open_ticket_id"] . "}");
    }

    header("Location: ../pages/user.php");
    exit();