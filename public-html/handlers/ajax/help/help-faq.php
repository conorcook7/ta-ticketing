<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once "../../../components/dao.php";
    require_once "../../components/server-functions.php";

    $logger = getServerLogger();
    $dao = new Dao();

    // Check if it is an actual AJAX request
    if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"] == ""){
        $logger->logWarn(basename(__FILE__) . ": User attempting to access handler page directly.");
        header("Location: ../../pages/403.php");
        exit();
    }

    $faqs = $dao->getFAQs();

    $cleanFaqs = Array();

    foreach ($faqs as $faq) {
        $cleanFaq["question"] = htmlentities($faq["question"]);
        $cleanFaq["answer"] = htmlentities($faq["answer"]);
        $cleanFaqs[] = $cleanFaq;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanFaqs);
    exit();