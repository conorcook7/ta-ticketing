<?php

    require_once "../../components/dao.php";

    $dao = new Dao();

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