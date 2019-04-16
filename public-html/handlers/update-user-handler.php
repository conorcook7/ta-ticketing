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
    $permissionID = $_POST["permissionID"];
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
            if($dao->isTeachingAssistant($user_id)) {
                if (!$dao->deleteTeachingAssistant($user_id)) {
                    $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
                }
            }
            if(!isset($_SESSION["failure"]) && $dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
                $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
            } 
            if($permissionID == 4){
                $created = $dao->createBlacklistEntry($admin_id, $email);
                if ($created && isset($_SESSION["success"])) {
                    $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName . " and blacklisted them.";
                } elseif ($created) {
                    $_SESSION["success"] = "Email was added to the blacklist.";
                } else {
                    $_SESSION["failure"] = "Unable to add email to the blacklist.";
                }
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