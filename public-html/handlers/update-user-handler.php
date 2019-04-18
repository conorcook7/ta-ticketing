<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();

    // Get the Admin by the ID
    $admin_id = $_SESSION['user']['user_id'];
    $admin = $dao->getUserById($admin_id);

    // Get the user by the ID
    $user_id = $_POST["userID"];
    $user = $dao->getUserById($user_id);

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["userEmail"];
    $courseId = $_POST["courseId"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
    $permissionID = $_POST["permissionID"];
    $permissionName = $permissionID == 0 ? "DELETE" : $dao->getPermissionByID($permissionID);

    //compares users to ensure only a user that has power over the other is updating.
    if(strtoupper($admin["permission_name"]) != "ADMIN" && $admin["permission_id"] <= $user["permission_id"]){
        $_SESSION["failure"] = "You do not have permission to update that user.";
        header("Location: ../pages/professor.php?page=users");
        exit;
    }

    // If delete option was selected
    if($permissionName == "DELETE"){
        if($dao->deleteUser($email) == TRUE){
            $_SESSION["success"] = "Deleted the user: " . $firstName . " " . $lastName;
        } else {
            $_SESSION["failure"] = "Failed to delete the user: " . $firstName . " " . $lastName;
        }
    
    // If the create new person option was selected
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
    
    // General case
    } else if(isset($user_id, $firstName, $lastName, $email, $permissionID, $admin_id)) {

        // If the option was not a TA
        if($permissionName != "TA"){
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
            if($permissionName == "DENIED"){
                $created = $dao->createBlacklistEntry($admin_id, $email);
                if ($created && isset($_SESSION["success"])) {
                    $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName . " and blacklisted them.";
                } elseif ($created) {
                    $_SESSION["success"] = "Email was added to the blacklist.";
                } else {
                    $_SESSION["failure"] = "Unable to add email to the blacklist.";
                }
            } else if ($dao->isBlacklisted($email)) {
                $dao->deleteBlacklistEntryByEmail($email);
            }
        
        // If the option was set to TA
        } else {
            if ($dao->isBlacklisted($email)) {
                $dao->deleteBlacklistEntryByEmail($email);
            }
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
    $page = $admin["permission_name"] == "ADMIN" ? "admin.php?id" : "professor.php?page";
    header("Location: ../pages/" . $page . "=users");
    exit;
?>