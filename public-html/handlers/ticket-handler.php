<?php
error_reporting(E_ALL);
session_start();
ini_set("display_errors","On");
require_once '../components/dao.php';
require_once '../components/server-functions.php';
$id = 'DEFAULT';
$permission = getPermission();
$dao = new Dao();

if(isset($_POST['open_ticket_id']) && isset($_POST['closer_user_id']) && isset($_POST['closing_description'])){
    $ticketClosed = $dao->closeTicket($_POST["open_ticket_id"] ,$_POST["closer_user_id"], $_POST['closing_description']);
    if($permission == "ADMIN"){
        $id = 'open-tickets';
    } else {
        $id = 'my-tickets';
    }
    if($ticketClosed){
        $_SESSION['success'] = 'Ticket has been closed.';
    } else {
        $_SESSION['failure'] = 'Ticket was unable to be closed.';
    }
} else {
    $_SESSION['failure'] = 'Ticket has not been closed.';
}

if(isset($_POST['closed_ticket_id'])){
    $openClosedTicket = $dao->openClosedTicket($_POST["closed_ticket_id"] ,$_POST["opener_id"]);
    $id = 'closed-tickets';
    if($openClosedTicket){
        $_SESSION['success'] = 'Ticket has been reopened.';
    } else {
        $_SESSION['failure'] = 'Ticket has not been reopened.';
    }
}
if($permission == "ADMIN"){
    $page = "Location: ../pages/admin.php?id=" . $id;
    header($page);
} else {
    $page = "Location: ../pages/ta.php?page=" . $id;
    header($page);
}
exit;