<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $admin_id = $_SESSION['user']['user_id'];
    $user_id = $_POST["userID"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["userEmail"];
    $courseId = $_POST["courseId"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $permissionID = intval(explode(" ", $_POST["permissionID"])[0]);
    if($permissionID == 0){
        if($dao->deleteUser($email) == TRUE){
            $_SESSION["success"] = "Deleted the user: " . $firstName . " " . $lastName;
        } else {
            $_SESSION["failure"] = "Failed to delete the user: " . $firstName . " " . $lastName;
        }
    } else if($user_id == -1){
        if($dao->createUser($email, $firstName, $lastName) == TRUE){
            if($dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
                $_SESSION["success"] = "Created the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
            }
            $_SESSION["success"] = "Created the user: " . $firstName . " " . $lastName;
        } else {
            $_SESSION["failure"] = "Failed to create the user: " . $firstName . " " . $lastName;
        }  
    } else if(isset($user_id, $firstName, $lastName, $email, $permissionID, $admin_id)) {
        if($permissionID != 2){
            if($dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
                $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
            }   
        } else {
            if ($dao->isTeachingAssistant($user_id)) {
                if ($dao->updateTeachingAssistant($user_id, $courseId, $startTime, $endTime) == TRUE) {
                    $_SESSION["success"] = "Updated teaching assistant: " . $firstName . " " . $lastName;
                } else {
                    $_SESSION["failure"] = "Failed to update the teaching assistant: " . $firstName . " " . $lastName;
                } 
                
            } else {
                if($dao->createTeachingAssistant($user_id, $courseId, $startTime, $endTime) == TRUE){
                    $_SESSION["success"] = "Created teaching assistant: " . $firstName . " " . $lastName;
                } else {
                    $_SESSION["failure"] = "Failed to create the teaching assistant: " . $firstName . " " . $lastName;
                } 
            }
        }
    }
    header("Location: ../pages/admin.php?id=users");
    exit;
?>