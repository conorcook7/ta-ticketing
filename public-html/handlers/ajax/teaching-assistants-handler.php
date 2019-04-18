<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once "../../components/dao.php";
    require_once "../../components/server-functions.php";

    $logger = getServerLogger();
    $dao = new Dao();

    // Check if it is an actual AJAX request
    if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"] == ""){
        $logger->logWarn(basename(__FILE__) . ": User attempting to access handler page directly.");
        header("Location: ../../pages/403.php");
        exit();
    }

    $teachingAssistants = $dao->getTeachingAssistants();

    $cleanTAs = Array();

    foreach ($teachingAssistants as $ta) {
        // Create the dates
        $startTime = new DateTime($ta["start_time_past_midnight"]);
        $endTime = new DateTime($ta["end_time_past_midnight"]);
        $createDate = new DateTime($ta["create_date"]);

        // Get the attributes
        $cleanTA["name"] = htmlentities($ta["first_name"] . " " . $ta["last_name"]);
        $cleanTA["course_number"] = htmlentities($ta["course_number"]);
        $cleanTA["email"] = htmlentities($ta["email"]);
        $cleanTA["schedule"] = $startTime->format("g:i A") . " - " . $endTime->format("g:i A");
        $cleanTA["course_name"] = htmlentities($ta["course_name"]);
        $cleanTA["course_description"] = htmlentities($ta["course_description"]);
        $cleanTA["create_date"] = $createDate->format("F jS Y");

        // Append to the list to return
        $cleanTAs[] = $cleanTA;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanTAs);