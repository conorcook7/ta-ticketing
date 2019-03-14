<?php
error_reporting(E_ALL);
ini_set("display_errors","On");

require_once '../components/dao.php';

$dao = new Dao('Dummy_TA_Ticketing');
if(isset($_POST['open_ticket_id_input'])){
    $closeTicket = $dao->closeTicket($_POST["open_ticket_id_input"] ,$_POST["closer_id_input"]);
}

if(isset($_POST['my_open_ticket_id_input'])){
    $closeTicket = $dao->closeTicket($_POST["my_open_ticket_id_input"] ,$_POST["my_closer_id_input"]);
}

if(isset($_POST['closed_ticket_id'])){
    $closeTicket = $dao->closeTicket($_POST["closed_ticket_id"] ,$_POST["opener_id"]);
}

header("Location: ../pages/ta.php");
exit;