<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $admin_id = $_SESSION['user']['user_id'];
    $user_id = $_POST["userID"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["userEmail"];
    $permissionID = $_POST["permissionID"];
    if($user_id == -1){
        if($dao->createUser($email, $firstName, $lastName) == TRUE){
            if($dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
                $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
            } else {
                $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
            }
            $_SESSION["success"] = "Created the user: " . $firstName . " " . $lastName;
        } else {
            $_SESSION["failure"] = "Failed to create the user: " . $firstName . " " . $lastName;
        }  
    } else {
        if($dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
            $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
        } else {
            $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
        }        
    }
    if($dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
        $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
    } else {
        $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
    }
    header("Location: ../pages/admin.php?id=users");
    exit;
?>