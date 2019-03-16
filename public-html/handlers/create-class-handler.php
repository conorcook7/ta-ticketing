<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $name = $_POST["courseName"];
    $number = $_POST["courseNumber"];
    $description = $_POST["courseDescription"];
    $dao->createCourse($name, $number, $description);
    $_SESSION["success"] = "Added the Class: " . name;
    header("Location: ../pages/admin.php?id=classes");
    exit;
?>