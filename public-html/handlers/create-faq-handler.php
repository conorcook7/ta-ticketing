<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $id = $_SESSION['user']['user_id'];
    $question = $_POST["question"];
    $answer = $_POST["answer"];
    if($dao->updateFAQ($id, $question, $answer) == TRUE){
        $_SESSION["success"] = "Updated the Question: " . $question;
    } else {
        if($dao->createFAQ($id, $question, $answer) == TRUE){
            $_SESSION["success"] = "Added the Question: " . $question;
        } else {
            $_SESSION["failure"] = "Failed to add the Question: " . $question;
        }
    }
    header("Location: ../pages/admin.php?id=faq");
    exit;
?>