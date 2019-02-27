<?php
error_reporting(E_ALL);
ini_set("display_errors","On");

require_once '../components/dao.php';

$dao = new Dao('Dummy_TA-Ticketing');
$users = $dao->getUsers();
$availableTAs = $dao->getAvailableTeachingAssistants();
$allOpenTickets = $dao->getOpenTickets();
$availableCourses = $dao->getAvailableCourses();
//getOnlineTAs
//getSpecificOpens
//closeTicket


// print_r($allOpenTickets);
foreach($allOpenTickets as $opens){
    echo $opens['open_ticket_id'] ,"<br>";
    echo $opens['opener_user_id']  ,"<br>";
}

// if(!empty($users)){
//     echo "Users has data <br>";
// }
// if(!empty($availableTAs)){
//     echo "Available TAS has data<br>";
// }
// if(!empty($allOpenTickets)){
//     echo "All Open tickets has data<br>";
// }
// if(!empty($availableCourses)){
//     echo "Available Courses has data<br>";
// }


// print_r($users);