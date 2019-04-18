<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    require_once '../components/dao.php';
    require_once '../components/server-functions.php';

    $dao = new Dao();
    $user_id = 0;
    $course_id = 0;
    if(isset($_SESSION['user']['email'])){
      $user = $dao->getUser($_SESSION['user']['email']);
      $user_id = $user['user_id'];
    }
    if(isset($_POST['courseID']) && isset($_POST['description']) && $user_id != 0){
        $descript = $_POST['description'];
        $course_id = $_POST['courseID'];
        $newTicket = $dao->createTicket($course_id,$user_id, $_SESSION["user"]["computer_name"],$descript);
    }
    if($newTicket){
      $_SESSION['success'] = 'New Ticket Has Been Created.';
    }else {
      $logger = getServerLogger();
      $logger->logError(__FILE__ . ": Unable to create new ticket from user {" . $user["user_id"] . "}");
      $_SESSION['failure'] = 'Unable to create new ticket';
    }

    header("Location: ../pages/user.php");
    exit;
?>
