<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $name = $_POST["courseName"];
    $number = $_POST["courseNumber"];
    $description = $_POST["courseDescription"];
    if($dao->createCourse($name, $number, $description) == TRUE){
        $_SESSION["success"] = "Added the Class: " . $name;
    } else {
        $_SESSION["failure"] = "Failed to add the Class: " . $name;
    }
    header("Location: ../pages/admin.php?id=classes");
    exit;
?>