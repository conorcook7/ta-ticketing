<?php

    session_start();
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    // Log where the user sent in the problem
    $logger = getServerLogger();
    $logger->logInfo(basename(__FILE__) . ": User attempting to send bug report {" . $_SESSION["user"]["user_id"] . "}");

    // Attempt to save the issue ot the database
    try {
        $title = isset($_POST["title"]) ? $_POST["title"] : "";
        $description = isset($_POST["description"]) ? $_POST["description"] : "";

        if ($title == "" && $description == "") {
            $_SESSION["presets"]["title"] = $title;
            $_SESSION["presets"]["description"] = $description;

            // Set the failure message
            $_SESSION["failure"] = "We are having issues saving your concern. You may contact 
                <a href='mailto: BenjaminPeterson@boisestate.edu'>Benjamin Peterson</a> for further assistance.";

            // Unset the post array and redirect to the bug report page
            unset($_POST);
            header("Location: ../pages/help/bug-report.php");
            exit();
        }

        // Attempt to insert the bug report
        $dao = new Dao();
        if ($dao->createBugReport($_SESSION["user"]["user_id"], $_POST["title"], $_POST["description"])) {
            $_SESSION["success"] = "Your concern has been emailed to all of the administrators.";
            if (isset($_SESSION["presets"])) {
                unset($_SESSION["presets"]);
            }
            unset($_POST);
            header("Location: ../pages/help/bug-report.php");
            exit();
        }
    } catch (Exception $e) {
        $logger->logError(basename(__FILE__) . ": Unable to save the user's issue to the database.");
        $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
    }

    $_SESSION["presets"]["title"] = $title;
    $_SESSION["presets"]["description"] = $description;

    // Set the failure message
    $_SESSION["failure"] = "We are having issues saving your concern. You may contact 
        <a href='mailto: BenjaminPeterson@boisestate.edu'>Benjamin Peterson</a> for further assistance.";

    // Unset the post array and redirect to the bug report page
    unset($_POST);
    header("Location: ../pages/help/bug-report.php");
    exit();