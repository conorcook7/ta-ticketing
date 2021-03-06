<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();

    // Get the Admin by the ID
    $originUserId = $_SESSION['user']['user_id'];
    $originUser = $dao->getUserById($originUserId);

    // Get the user by the ID
    $targetUserId = $_POST["userID"];
    $targetUser = $dao->getUserById($targetUserId);

    $targetFirstName = $_POST["firstName"];
    $targetLastName = $_POST["lastName"];
    $targetEmail = $_POST["userEmail"];
    $courseId = $_POST["courseId"];
    $permissionID = $_POST["permissionID"];
    $permissionName = $permissionID == 0 ? "DELETE" : $dao->getPermissionByID($permissionID);

    // Only check if the person updating is not an admin
    if(strtoupper($originUser["permission_name"]) != "ADMIN") {
        //compares users to ensure only a user that has power over the other is updating.
        if ($originUser["permission_id"] <= $targetUser["permission_id"]) {
            $_SESSION["failure"] = "You do not have permission to update that user.";
            header("Location: ../pages/professor.php?page=users");
            exit;
        }
        // Checking that the professor does not set a user higher than themselves
        if ($originUser["permission_id"] <= $permissionID) {
            if ($permissionName == "DENIED") {
                $_SESSION["failure"] = "You do not have permission to blacklist users.";
            } else {
                $_SESSION["failure"] = "You do not have permission to set the user's permission to: " . strtolower($permissionName);
            }
            header("Location: ../pages/professor.php?page=users");
            exit;
        }
    } 

    // If delete option was selected
    if($permissionName == "DELETE"){
        // Restict delete to admins only
        if (strtoupper($originUser["permission_name"]) == "ADMIN") {
            if($dao->deleteUser($targetEmail) == TRUE){
                $_SESSION["success"] = "Deleted the user: " . $targetFirstName . " " . $targetLastName;
            } else {
                $_SESSION["failure"] = "Failed to delete the user: " . $targetFirstName . " " . $targetLastName;
            }
        } else {
            $_SESSION["failure"] = "You do not have permission to delete users.";
        }
    
    // If the create new person option was selected
    } else if($targetUserId == -1){
        if($dao->createUser($targetEmail, $targetFirstName, $targetLastName) == TRUE){
            if($dao->updateUser($targetUserId, $targetFirstName, $targetLastName, $targetEmail, $permissionID, $originUserId) == TRUE){
                $_SESSION["success"] = "Created the user: " . $targetFirstName . " " . $targetLastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $targetFirstName . " " . $targetLastName;
            }
            $_SESSION["success"] = "Created the user: " . $targetFirstName . " " . $targetLastName;
        } else {
            $_SESSION["failure"] = "Failed to create the user: " . $targetFirstName . " " . $targetLastName;
        }
    
    // General case
    } else if(isset($targetUserId, $targetFirstName, $targetLastName, $targetEmail, $permissionID, $originUserId)) {

        // If the option was not a TA
        if($permissionName != "TA"){
            // Remove the user from TAs
            if($dao->isTeachingAssistant($targetUserId)) {
                if (!$dao->deleteTeachingAssistant($targetUserId)) {
                    $_SESSION["failure"] = "Failed to update the user: " . $targetFirstName . " " . $targetLastName;
                }
            }
            // Attempt to update the user
            if(!isset($_SESSION["failure"]) && $dao->updateUser($targetUserId, $targetFirstName, $targetLastName, $targetEmail, $permissionID, $originUserId) == TRUE){
                $_SESSION["success"] = "Updated the user: " . $targetFirstName . " " . $targetLastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $targetFirstName . " " . $targetLastName;
            }
            // Blacklist the user if permission is denied
            if($permissionName == "DENIED"){
                if (strtoupper($originUser["permission_name"]) == "ADMIN") {
                    if ($dao->createBlacklistEntry($originUserId, $targetEmail)) {
                        $_SESSION["success"] = "Updated and blacklisted the user: " . $targetFirstName . " " . $targetLastName;
                    } else {
                        $_SESSION["failure"] = "Unable to add email to the blacklist.";
                    }
                } else {
                    $_SESSION["failure"] = "You do not have the permission to blacklist users.";
                }
            } else if ($dao->isBlacklisted($targetEmail)) {
                $dao->deleteBlacklistEntryByEmail($targetEmail);
            }
        
        // If the option was set to TA
        } else {
            if ($dao->isBlacklisted($targetEmail)) {
                $dao->deleteBlacklistEntryByEmail($targetEmail);
            }
            if ($dao->isTeachingAssistant($targetUserId)) {
                if ($dao->updateTeachingAssistant($targetUserId, $courseId) == TRUE) {
                    $_SESSION["success"] = "Updated teaching assistant: " . $targetFirstName . " " . $targetLastName;
                } else {
                    $_SESSION["failure"] = "Failed to update the teaching assistant: " . $targetFirstName . " " . $targetLastName;
                } 
                
            } else {
                if($dao->createTeachingAssistant($targetUserId, $courseId) == TRUE){
                    $_SESSION["success"] = "Created teaching assistant: " . $targetFirstName . " " . $targetLastName;
                } else {
                    $_SESSION["failure"] = "Failed to create the teaching assistant: " . $targetFirstName . " " . $targetLastName;
                } 
            }
        }
    }
    $page = $originUser["permission_name"] == "ADMIN" ? "admin.php?id" : "professor.php?page";
    header("Location: ../pages/" . $page . "=users");
    exit();
