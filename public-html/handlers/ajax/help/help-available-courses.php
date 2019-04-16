<?php

    require_once "../../../components/dao.php";

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
        $cleanCourses[] = $cleanCourse;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanCourses);
    exit();