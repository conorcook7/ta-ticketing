<?php

    require_once "../../components/dao.php";

    $dao = new Dao();

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