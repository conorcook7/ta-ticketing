<?php
/**
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

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
            // Create the bug report for the server
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Bug_Reports (creator_user_id, title, description)
                VALUES (:userId, :title, :description);"
            );
            $query->bindParam(":userId", $userId);
            $query->bindParam(":title", $title);
            $query->bindParam(":description", $description);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Bug report created by user {" . $userId . "}");
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to create bug report.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
        try {
            // Get all of the admin email addresses
            $query = $conn->prepare(
                "SELECT email FROM Users
                JOIN Permissions ON Users.permission_id = Permissions.permission_id
                WHERE permission_name = 'ADMIN';"
            );
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $adminEmails = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Obtained all of the admin emails");

            // Get the user's information that generated the bug report
            $query = $conn->prepare("SELECT first_name, last_name, email FROM Users WHERE user_id = :userId;");
            $query->bindParam(":userId", $userId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $creator = $query->fetch();

            // Create the message to send
            if(!empty($adminEmails)) {
                // Assign the person receiving the email
                $to = $adminEmails[0]["email"];

                // Create a subject line
                $subject = "TA Ticketing Bug Report";

                // Create header to the email
                $headers = "From: no-reply@taticketing.boisestate.edu" . "\r\n" . "CC: ";
                for ($i = 1; $i < count($adminEmails); $i++) {
                    $headers .= $adminEmails[$i]["email"] . " ";
                }
                $headers .= "\r\nMIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";

                // Create the general message
                $message = "<html><body>";

                $message .= "<p>Hello,</p><p>" . htmlentities($creator["first_name"] . " " . $creator["last_name"]) . " just created a new bug report!</p>";
                $message .= "<p><strong>Author's Email:</strong> " . htmlentities($creator["email"]) . "</p>";
                $message .= "<div><strong>Title: </strong>" . htmlentities($title) . "</div><div><strong>Description:</strong></div><div><p>" . $description . "</div></p>";
                $message .= "<p><em>This is an automated message sent by the TA Ticketing Service at Boise State University.</em></p>";
                $message .= "<p>TA Ticketing &copy; Boise State University<p>";

                $message .= "</body></html>";
                

                // Send the email to all admins (including the taticketing@boisestate.edu email account)
                $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Attempting to send the email");
                $sent = mail($to, $subject, $message, $headers);

                // If the email was sent successfully from the server
                // There are no guarantees that it reaches its destination
                if ($sent) {
                    $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Email sent to all admins");
                } else {
                    $this->logger->logWarn(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Unable to send email to all admins");
                }
            }
            
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": Unable to send bug report email.");
            $this->logger->logError(basename(__FILE__) . ": " . __FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
        return $this->SUCCESS;
    }

    /**
     * Get all of the bug reports from the database.
     * @return $bugReports - The associative array of bug report information.
     */
    function getBugReports() {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT * FROM Bug_Reports AS BR
                JOIN Users AS U ON BR.creator_user_id = U.user_id
                WHERE active = 1;"
            );
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
            $query = $conn->prepare(
                "SELECT * FROM Bug_Reports AS BR
                JOIN Users AS U ON BR.creator_user_id = U.user_id
                WHERE bug_report_id = :bugReportId;"
            );
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
     * Resolve the bug report to set the active state to 0
     * @param $bugReportId - The bug report to solve
     * @param $userId - Person that is solving the bug report
     * @param $description - The description of the solved bug report
     * @param $title - The title of the bug report solved
     * @return Returns TRUE if the update was successful, else FALSE
     */
    function resolveBugReport($bugReportId, $userId, $description, $title) {
        try {
            $conn = $this->getConnection();

            // Close the bug report
            $query = $conn->prepare(
                "UPDATE Bug_Reports
                SET active = 0,
                    closer_user_id = :userId,
                    closing_description = :description
                WHERE bug_report_id = :bugReportId;"
            );
            $query->bindParam(":userId", $userId);
            $query->bindParam(":description", $description);
            $query->bindParam(":bugReportId", $bugReportId);
            $closedBugReport = $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Closed the bug report");

            // Get the email of the closer
            $query = $conn->prepare(
                "SELECT email FROM Users AS U
                LEFT JOIN Bug_Reports AS BR ON U.user_id = BR.creator_user_id
                WHERE BR.bug_report_id = :bugReportId;"
            );
            $query->bindParam(":bugReportId", $bugReportId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $creatorEmail = $query->fetch()["email"];
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Obtained creator's email");

            // Get the closer
            $query = $conn->prepare(
                "SELECT first_name, last_name, email
                FROM Users WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $closer = $query->fetch();
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Obtained the closing user");

            // Create the message to send
            if($closedBugReport && $creatorEmail != "" && !empty($closer)) {
                // Assign the person receiving the email
                $to = $creatorEmail;

                // Create a subject line
                $subject = "TA Ticketing Bug Report Resolved";

                // Create header to the email
                $headers = "From: no-reply@taticketing.boisestate.edu" . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=utf-8\r\n";

                // Create the general message
                $message = "<html><body>";

                $message .= "<p>Hello,</p><p>" . htmlentities($closer["first_name"] . " " . $closer["last_name"]) . " just closed your bug report!</p>";
                $message .= "<p><strong>Author's Email:</strong> " . htmlentities($closer["email"]) . "</p>";
                $message .= "<div><strong>Title: </strong>" . htmlentities($title) . "</div>";
                $message .= "<p><em>This is an automated message sent by the TA Ticketing Service at Boise State University.</em></p>";
                $message .= "<p>TA Ticketing &copy; Boise State University<p>";

                $message .= "</body></html>";
                

                // Send the email to all admins (including the taticketing@boisestate.edu email account)
                $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Attempting to send the email");
                $sent = mail($to, $subject, $message, $headers);

                // If the email was sent successfully from the server
                // There are no guarantees that it reaches its destination
                if ($sent) {
                    $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Email sent to user");
                } else {
                    $this->logger->logWarn(basename(__FILE__) . ": " . __FUNCTION__ . ": " . "Unable to send email to user");
                }
            }
            $this->logger->logDebug(basename(__FILE__) . ": " . __FUNCTION__ . ": Bug report resolved {" . $bugReportId . "}");
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
