<?php

    session_start();
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    // Log where the user sent in the problem
    $logger = getServerLogger();
    $logger->logInfo(basename(__FILE__) . ": User attempting to send bug report {" . $_SESSION["user"]["user_id"] . "}");

    // Attempt to save the issue ot the database
    try {
        $dao = new Dao();
        if ($dao->createBugReport($_SESSION["user"]["user_id"], $_POST["title"], $_POST["description"])) {
            $_SESSION["success"] = "Your concern has been saved for an administrator to view.";
        } else {
            $_SESSION["presets"]["title"] = isset($_POST["title"]) ? $_POST["title"] : "";
            $_SESSION["presets"]["description"] = isset($_POST["description"]) ? $_POST["description"] : "";
            $_SESSION["failure"] = "Unable to save your concern. Please try again later.";
        }
    } catch (Exception $e) {
        $logger->logError(basename(__FILE__) . ": Unable to save the user's issue to the database.");
        $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
        $_SESSION["presets"]["title"] = isset($_POST["title"]) ? $_POST["title"] : "";
        $_SESSION["presets"]["description"] = isset($_POST["description"]) ? $_POST["description"] : "";
        $_SESSION["failure"] = "We are having issues saving your concern. You may contact Benjamin Peterson at BenjaminPeterson@boisestate.edu for further assistance.";
    }

    // Unset the post array and redirect to the bug report page
    unset($_POST);
    header("Location: ../pages/help/bug-report.php");
    exit();