<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();

    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    $logger = getServerLogger();
    $bugReportId = isset($_POST["bugReportId"]) ? $_POST["bugReportId"] : -1;
    $bugReportTitle = isset($_POST["bugReportTitle"]) ? $_POST["bugReportTitle"] : "";
    $resolveDescription = isset($_POST["resolveDescription"]) ? $_POST["resolveDescription"] : "No Description";

    // Check that the id could be found
    if ($bugReportId == -1) {
        $logger->logError(basename(__FILE__) . ": Unable to find bug report id in POST array.");
        $_SESSION["bug-report-failure"] = "Unable to find the bug report id.";
        header("Location: ../pages/admin.php?id=bug-reports");
        exit();
    }

    // Attempt to remove the ticket
    try {
        $dao = new Dao();
        if ($dao->resolveBugReport($bugReportId, $_SESSION["user"]["user_id"], $resolveDescription, $bugReportTitle)) {
            $logger->logDebug(basename(__FILE__) . ": Resolved bug report {" . $bugReportId . "}");
            $_SESSION["bug-report-success"] = "Resolved bug report: " . htmlentities($bugReportTitle);
        } else {
            $logger->logError(basename(__FILE__) . ": Unable to resolve bug report with dao function.");
            $_SESSION["bug-report-failure"] = "Could not resolve the bug report. Please try again.";
        }

    } catch (Exception $e) {
        $logger->logError(basename(__FILE__) . ": Unable to resolve bug report {" . $bugReportId . "}");
        $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
        $_SESSION["bug-report-failure"] = "Could not resolve the bug report. Please try again.";
    }

    // Redirect to the original page
    header("Location: ../pages/admin.php?id=bug-reports");
    exit();