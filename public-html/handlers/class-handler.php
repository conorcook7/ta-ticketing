<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $name = $_POST["courseName"];
    $number = $_POST["courseNumber"];
    $description = $_POST["courseDescription"];
    if(isset($_POST["classID"])){
        $id = $_POST["classID"]
        if($dao->updateCourse($id, $name, $number, $description) == TRUE){
            $_SESSION["success"] = "Updated the Class: " . $name;
        } else {
            $_SESSION["failure"] = "Failed to update the Class: " . $name;
        }
    } else {
        if($dao->createCourse($name, $number, $description) == TRUE){
            $_SESSION["success"] = "Added the Class: " . $name;
        } else {
            $_SESSION["failure"] = "Failed to add the Class: " . $name;
        }
    }   
    header("Location: ../pages/admin.php?id=classes");
    exit;
?>