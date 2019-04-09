<?php

/**
 * Bug Report trait to contain the dao functions for the bug report table.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoBugReport {

    /**
     * Create a bug report.
     * 
     * @param $userId - The user that is creating the bug report
     * @param $title - The title of the bug report
     * @param $description - The description of the report
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    function createBugReport($userId, $title, $description) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("INSERT INTO Bug_Reports (user_id, title, description) VALUES (:userId, :title, :description);");
            $query->bindParam(":userId", $userId);
            $query->bindParam(":title", $title);
            $query->bindParam(":description", $description);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Bug report created by user {" . $userId . "}");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create bug report.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the bug reports from the database.
     * @return $bugReports - The associative array of bug report information.
     */
    function getBugReports() {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT * FROM Bug_Reports");
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $bugReport = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Fetch all bug reports complete");
            return $bugReport;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create bug report.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Get a bug report by the id.
     * @param $bugReportId - The id of the bug report to get.
     * @return $bugReport - The bug report information found by the bug report id.
     */
    function getBugReportById($bugReportId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT * FROM Bug_Reports WHERE bug_report_id = :bugReportId;");
            $query->bindParam($bugReportId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $bugReport = $query->fetch();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Fetch bug report by id complete");
            return $bugReport;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create bug report.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Update the title and description of the bug report.
     * @param $bugReportId - The id of the bug report to update.
     * @param $title - The new title of the bug report.
     * @param $description - The new description of the report
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    function updateBugReport($bugReportId, $title, $description) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("UPDATE Bug_Reports SET title = :title, description = :description WHERE bug_report_id = :bugReportId;");
            $query->bindParam(":title", $title);
            $query->bindParam(":description", $description);
            $query->bindParam(":bugReportId", $bugReportId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Updated the bug report {" . $bugReportId . "}");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create bug report.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Delete the bug report by the id.
     * @param $bugReportId - The id of the bug report to delete from the database.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    function deleteBugReport($bugReportId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("DELETE FROM Bug_Reports WHERE bug_report_id = :bugReportId;");
            $query->bindParam(":bugReportId", $bugReportId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Bug report deleted {" . $bugReportId . "}");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create bug report.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }
}