<?php

    session_start();
    
    require_once "../../components/dao.php";
    require_once "../../components/server-functions.php";

    $permission = getPermission();

    if ($permission === "ADMIN" || $permission === "PROFESSOR") {
        // Get the dao object
        $dao = new Dao();

        $taID = isset($_GET["taID"]) ? $_GET["taID"] : 0;
        $ta = $dao->getTeachingAssistantById($taID);

        // Extract relevant data
        $data = Array();
        $data["startTime"] = $ta["start_time_past_midnight"];
        $data["endTime"] = $ta["end_time_past_midnight"];
        $data["courseId"] = $ta["available_course_id"];
    } else {
        header("HTTP/1.0 403 Forbidden");
        exit();
    }

    header("Content-Type: application/json");
    echo json_encode($data);
