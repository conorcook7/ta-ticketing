<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $id = isset($_POST["classID"]) ? $_POST["classID"] : NULL;
    $name = $_POST["courseName"];
    $number = $_POST["courseNumber"];
    $description = $_POST["courseDescription"];
    $URL = isset($_POST["taScheduleURL"]) ? $_POST["taScheduleURL"] : NULL;

    if(isset($_POST["delete"])){
        $id = $_POST["classID"];
        if($dao->deleteAvailableCourse($id) == TRUE){
            $_SESSION["success"] = "Deleted the Class: " . $name;
        } else {
            $_SESSION["failure"] = "Failed to delete the Class: " . $name;
        }
    } else if ($id != NULL) {
        if($dao->updateCourse($id, $name, $number, $description, $URL) == TRUE){
            $_SESSION["success"] = "Updated the Class: " . $name;
        } else {
            $_SESSION["failure"] = "Failed to update the Class: " . $name;
        }
    } else if(isset($name, $number, $description, $URL)) {
        if($dao->createCourse($name, $number, $description, $URL) == TRUE){
            $_SESSION["success"] = "Added the Class: " . $name;
        } else {
            $_SESSION["failure"] = "Failed to add the Class: " . $name;
        }
    }   
    header("Location: ../pages/admin.php?id=classes");
    exit;
?>