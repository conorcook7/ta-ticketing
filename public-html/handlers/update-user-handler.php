<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $admin_id = $_SESSION['user']['user_id'];
    $user_id = $_POST["userID"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $permissionID = $_POST["permissionID"];
    if($dao->updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id) == TRUE){
        $_SESSION["success"] = "Updated the user: " . $firstName . " " . $lastName;
    } else {
        $_SESSION["failure"] = "Failed to update the user: " . $firstName . " " . $lastName;
    }
    header("Location: ../pages/admin.php?id=users");
    exit;
?>