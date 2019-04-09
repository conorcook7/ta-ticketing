<?php

    session_start();

    require_once "../components/dao.php";
    require_once "../components/server-functions.php";

    $logger = getServerLogger();
    $bugReportId = isset($_POST["bugReportId"]) ? $_POST["bugReportId"] : -1;
    $bugReportTitle = isset($_POST["bugReportTitle"]) ? $_POST["bugReportTitle"] : "";

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
        if ($dao->deleteBugReport($bugReportId)) {
            $logger->logDebug(basename(__FILE__) . ": Deleted bug report {" . $bugReportId . "}");
            $_SESSION["bug-report-success"] = "Deleted bug report: " . htmlentities($bugReportTitle);
        } else {
            $logger->logError(basename(__FILE__) . ": Unable to delete bug report with dao function.");
            $_SESSION["bug-report-failure"] = "Could not delete the bug report. Please try again.";
        }

    } catch (Exception $e) {
        $logger->logError(basename(__FILE__) . ": Unable to delete bug report {" . $bugReportId . "}");
        $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
        $_SESSION["bug-report-failure"] = "Could not delete the bug report. Please try again.";
    }

    // Redirect to the original page
    header("Location: ../pages/admin.php?id=bug-reports");
    exit();