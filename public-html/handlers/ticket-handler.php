<?php
error_reporting(E_ALL);
session_start();
ini_set("display_errors","On");
require_once '../components/dao.php';
$id = 'DEFAULT';

$dao = new Dao();
if(isset($_POST['open_ticket_id_input'])){
    $cleanTextAllTicket = strip_tags($_POST["limitedtextarea"]);
    $closeTicket = $dao->closeTicket($_POST["open_ticket_id_input"] ,$_POST["closer_id_input"], $cleanTextAllTicket);
    $id = 'open-tickets';
    if($closeTicket){
        $_SESSION['success'] = 'Ticket has been closed.';
    } else {
        $_SESSION['failure'] = 'Ticket has not been closed.';
    }
}

if(isset($_POST['my_open_ticket_id']) && isset($_POST['my_closer_user_id']) && isset($_POST['my_closing_description'])){
    $ticketClosed = $dao->closeTicket($_POST["my_open_ticket_id"] ,$_POST["my_closer_user_id"], $_POST['my_closing_description']);
    if($_SESSION['user']['access_level'] >= 3){
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
if($_SESSION['user']['access_level'] >= 3){
    $page = "Location: ../pages/admin.php?id=" . $id;
    header($page);
} else {
    $page = "Location: ../pages/ta.php?page=" . $id;
    header($page);
}
exit;