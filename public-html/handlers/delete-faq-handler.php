<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    require_once "../components/dao.php";
    $dao = new Dao();
    $id = $_SESSION['user']['user_id'];
    $question = $_POST["question"];
    $answer = $_POST["answer"];
    if(isset($_POST["faqID"])){
        $faqID = $_POST["faqID"];
        if($dao->deleteFAQ($faqID) == TRUE){
            $_SESSION["success"] = "Deleted the Question: " . $question;
        } else {
            $_SESSION["failure"] = "Failed to delete the Question: " . $question;
        }
    } else {
        $_SESSION["failure"] = "Failed to delete the Question: " . $question;
    }
    header("Location: ../pages/admin.php?id=faq");
    exit;
?>