<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once "../../../components/dao.php";
    require_once "../../../components/server-functions.php";

    $logger = getServerLogger();
    $dao = new Dao();

    // Check if it is an actual AJAX request
    if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"] == ""){
        $logger->logWarn(basename(__FILE__) . ": User attempting to access handler page directly.");
        header("Location: ../../pages/403.php");
        exit();
    }

    $availableCourses = $dao->getAvailableCourses();

    $cleanCourses = Array();

    foreach ($availableCourses as $course) {
        $cleanCourse["course_name"] = htmlentities($course["course_name"]);
        $cleanCourse["course_description"] = htmlentities($course["course_description"]);
        $cleanCourse["course_number"] = htmlentities($course["course_number"]);
        $cleanCourse["ta_schedule_URL"] = htmlentities($course["ta_Schedule_URL"]);
        $cleanCourses[] = $cleanCourse;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanCourses);
    exit();