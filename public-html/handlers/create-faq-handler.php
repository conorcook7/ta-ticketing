<?php
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $id = $_SESSION['user']['user_id'];
    $question = $_POST["question"];
    $answer = $_POST["answer"];
    $dao->createFAQ($id, $question, $answer);
    $_SESSION["success"] = "Added the Question: " . question;
    header("Location: ../pages/admin.php?id=faq");
    exit;
?>