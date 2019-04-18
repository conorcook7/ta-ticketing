<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();

    // Get the Admin by the ID
    $originUserId = $_SESSION['user']['user_id'];
    $originUser = $dao->getUserById($originUserId);

    // Get the user by the ID
    $targetUserId = $_POST["userID"];
    $targetUser = $dao->getUserById($targetUserId);

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["userEmail"];
    $courseId = $_POST["courseId"];
    $startTime = $_POST["startTime"];
    $endTime = $_POST["endTime"];
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
            $_SESSION["failure"] = "You may only set the user's permission to one that is lower than your current permission." . $originUser["permission_id"] . " " .$permissionID;
            header("Location: ../pages/professor.php?page=users");
            exit;
        }
    } 

    // If delete option was selected
    if($permissionName == "DELETE"){
        // Restict delete to admins only
        if (strtoupper($originUser["permission_name"]) == "ADMIN") {
            if($dao->deleteUser($email) == TRUE){
                $_SESSION["success"] = "Deleted the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to delete the user: " . $firstName . " " . $lastName;
            }
        } else {
            $_SESSION["failure"] = "You do not have permission to delete users.";
        }
    
    // If the create new person option was selected
    } else if($targetUserId == -1){
        if($dao->createUser($email, $firstName, $lastName) == TRUE){
            if($dao->updateUser($targetUserId, $firstName, $lastName, $email, $permissionID, $originUserId) == TRUE){
                $_SESSION["success"] = "Created the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
            }
            $_SESSION["success"] = "Created the user: " . $firstName . " " . $lastName;
        } else {
            $_SESSION["failure"] = "Failed to create the user: " . $firstName . " " . $lastName;
        }
    
    // General case
    } else if(isset($targetUserId, $firstName, $lastName, $email, $permissionID, $originUserId)) {

        // If the option was not a TA
        if($permissionName != "TA"){
            if($dao->isTeachingAssistant($targetUserId)) {
                if (!$dao->deleteTeachingAssistant($targetUserId)) {
                    $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
                }
            }
            if(!isset($_SESSION["failure"]) && $dao->updateUser($targetUserId, $firstName, $lastName, $email, $permissionID, $originUserId) == TRUE){
                $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
            } 
            if($permissionName == "DENIED"){
                $created = $dao->createBlacklistEntry($originUserId, $email);
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
            if ($dao->isTeachingAssistant($targetUserId)) {
                if ($dao->updateTeachingAssistant($targetUserId, $courseId, $startTime, $endTime) == TRUE) {
                    $_SESSION["success"] = "Updated teaching assistant: " . $firstName . " " . $lastName;
                } else {
                    $_SESSION["failure"] = "Failed to update the teaching assistant: " . $firstName . " " . $lastName;
                } 
                
            } else {
                if($dao->createTeachingAssistant($targetUserId, $courseId, $startTime, $endTime) == TRUE){
                    $_SESSION["success"] = "Created teaching assistant: " . $firstName . " " . $lastName;
                } else {
                    $_SESSION["failure"] = "Failed to create the teaching assistant: " . $firstName . " " . $lastName;
                } 
            }
        }
    }
    $page = $originUser["permission_name"] == "ADMIN" ? "admin.php?id" : "professor.php?page";
    header("Location: ../pages/" . $page . "=users");
    exit;
?>