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
        if($dao->updateFAQ($faqID, $id, $question, $answer) == TRUE){
            $_SESSION["success"] = "Updated the Question: " . $question;
        } else {
            $_SESSION["failure"] = "Failed to update the Question: " . $question;
        }
    } else if(isset($question, $answer)) {
        if($dao->createFAQ($id, $question, $answer) == TRUE){
            $_SESSION["success"] = "Added the Question: " . $question;
        } else {
            $_SESSION["failure"] = "Failed to add the Question: " . $question;
        }
    }
    header("Location: ../pages/admin.php?id=faq");
    exit;
?>