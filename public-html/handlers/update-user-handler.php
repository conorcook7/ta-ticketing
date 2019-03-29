<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $id = $_POST["userID"];
    $name = $_POST["firstName"] . " " . $_POST["lastName"];
    $permission = $_POST["permissionID"];
    $dao->updateUser($id, $permission);
    $_SESSION["success"] = "Updated the user: " . $name;
    header("Location: ../pages/admin.php?id=users-form");
    exit;
?>