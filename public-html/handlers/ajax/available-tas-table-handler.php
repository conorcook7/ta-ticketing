<?php

    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();

    // Check if it is an actual AJAX request
    // if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"] == ""){
    //     $logger->logWarn(basename(__FILE__) . ": User attempting to access handler page directly.");
    //     header("Location: ../../pages/403.php");
    //     exit();
    // }

    // If the request is an AJAX request
    $availableTeachingAssistants = $dao->getAvailableTeachingAssistants();
    $cleanTAs = [
        "data" => array()
    ];

    foreach($availableTeachingAssistants as $ta) {
        $startTime = new DateTime($ta["start_time_past_midnight"]);
        $endTime = new DateTime($ta["end_time_past_midnight"]);
        $course = $dao->getAvailableCourseById($ta['available_course_id']);
        $cleanTA = Array();
        $cleanTA["taName"] = htmlentities($ta["first_name"] . " " . $ta["last_name"]);
        $cleanTA["taEmail"] = htmlentities($ta["email"]);
        $cleanTA["taTimeSlot"] = $startTime->format("g:i A") . " - " . $endTime->format("g:i A");
        $cleanTA["taCourse"] = htmlentities($course["course_name"]);
        $cleanTAs["data"][] = $cleanTA;
    }

    // Return the data
    header("Content-Type: application/json");
    echo json_encode($cleanTAs);