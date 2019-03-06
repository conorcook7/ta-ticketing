<?php
error_reporting(E_ALL);
ini_set("display_errors","On");

require_once '../components/dao.php';

$dao = new Dao('Dummy_TA_Ticketing');

$closeTicket = $dao->closeTicket($_POST["open_ticket_id_input"] ,$_POST["closer_id_input"]);

header("Location: ../pages/ta.php");
exit;