<?php
/**
 * Teaching Assistants trait to contain the dao functions.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoTa {

    /**
     * Checks if the user is a TA.
     * 
     * @param $userId - The user_id of the active user.
     * @return Returns TRUE if the userId is a TA, FALSE if it is not, NULL if there was an error
     */
    public function isTeachingAssistant($userId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT COUNT(*) FROM Teaching_Assistants WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
            $query->execute();
            $results = $query->fetch(PDO::FETCH_ASSOC);
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetching count");
            $result = $results["COUNT(*)"];
            if ($result) {
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): result is true");
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): count = " . $result);
                return TRUE;
            } else {
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): result is false");
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): count = " . $result);
                return FALSE;
            }
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to verify if user is a TA");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return NULL;
        }
    }

    /**
     * Returns all of the teaching assistants with information about them.
     * 
     * @param $limit - (optional) A limit to the number of teaching assistants to return.
     * @return $teachingAssistants - The array of arrays for each teaching assistant.
     */
    public function getTeachingAssistants($limit=NULL) {
        try {
            $conn = $this->getConnection();
            if ($limit == NULL) {
                $query = $conn->prepare(
                    "SELECT * FROM Teaching_Assistants AS TA JOIN Users AS U
                    ON TA.user_id = U.user_id;"
                );
            } else {
                $query = $conn->prepare(
                    "SELECT * FROM Teaching_Assistants AS TA JOIN Users AS U
                    ON TA.user_id = U.user_id LIMIT :limit;"
                );
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Query complete");
            $teachingAssistants = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all results complete");
            return $teachingAssistants;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get all TAs");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Create a new teaching assistant based on an existing user.
     * 
     * @param $userId - The user id of the student to add to the TAs.
     * @param $courseId - The course id of the class the TA is hired for.
     * @param $startTime - The start time past midnight for the TA to work.
     * @param $endTime - The end time past midnight for the TA to stop work.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createTeachingAssistant($userId, $courseId, $startTime, $endTime) {
        try {
            $conn = $this->getConnection();

            // Create the TA row 
            $query = $conn->prepare(
                "INSERT INTO Teaching_Assistants (user_id, available_course_id,
                start_time_past_midnight, end_time_past_midnight) VALUES (
                :userId, :courseId, :startTime, :endTime)"
            );
            $query->bindParam(":userId", $userId);
            $query->bindParam(":courseId", $courseId);
            $query->bindParam(":startTime", $startTime);
            $query->bindParam(":endTime", $endTime);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): TA was created");

            // Update the users permission level
            $query = $conn->prepare(
                "UPDATE Users SET permission_id = 2 WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Updated the user's permissions");
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to create TA");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Update a teaching assistant based on an existing user.
     * 
     * @param $userId - The user id of the TA to update.
     * @param $courseId - The course id of the class the TA is hired for.
     * @param $startTime - The start time past midnight for the TA to work.
     * @param $endTime - The end time past midnight for the TA to stop work.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function updateTeachingAssistant($userId, $courseId, $startTime, $endTime) {
        try {
            $conn = $this->getConnection();

            // Create the TA row 
            $query = $conn->prepare(
                "UPDATE Teaching_Assistants SET available_course_id = :courseId,
                start_time_past_midnight = :startTime, end_time_past_midnight = :endTime
                WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
            $query->bindParam(":courseId", $courseId);
            $query->bindParam(":startTime", $startTime);
            $query->bindParam(":endTime", $endTime);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): TA was updated");
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to create TA");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Delete a teaching assistant and change the user permissions to user status.
     * 
     * @param $userId - The user id of the person to remove from TAs.
     * @return Return TRUE if the delete was successful, else FALSE.
     */
    public function deleteTeachingAssistant($userId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "DELETE FROM Teaching_Assistants
                 WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Deleted teaching assistant");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to delete teaching assistant");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    public function getMyCourseID($ta_user_id) {
        try {
            $conn = $this->getConnection();
            $query = "SELECT
                        AC.available_course_id
                    FROM
                        Available_Courses AC
                    JOIN
                        Teaching_Assistants TA ON TA.available_course_id=AC.available_course_id
                    WHERE
                        TA.user_id = :ta_id_input";
            if ($limit == NULL) {
                $query = $conn->prepare($query);
            } else {
                $query .= " LIMIT :limit;";
                $query = $conn->prepare($query);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->bindParam(":ta_id_input", $ta_user_id);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Query completed");
            $myID = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all data completed");
            return $myID;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get my open tickets");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the teaching assistants online right now.
     * 
     * @return $availableTeachingAssistants - The TAs online right now.
     */
    public function getAvailableTeachingAssistants() {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT * FROM Teaching_Assistants INNER JOIN Users
                ON Teaching_Assistants.user_id = Users.user_id
                WHERE Users.online != 0;"
            );
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Query completed");
            $availableTeachingAssistants = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all data completed");
            return $availableTeachingAssistants;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get available teaching assistants");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Gets all open tickets for the corresponding TA
     * 
     * @param $limit - (optional) A limit to the number of tickets returned.
     * @return $myTickets - open tickets for that specific TA
     */
    public function getMyOpenTickets($teaching_assistant_id, $limit=NULL) {
        try {
            $conn = $this->getConnection();
            $query = "SELECT
                        open_ticket_id,
                        course_name,
                        OT.update_date,
                        first_name,
                        last_name,
                        node_number,
                        online, 
                        description
                    FROM
                        Open_Tickets OT
                    JOIN
                        Available_Courses AC ON OT.available_course_id=AC.available_course_id
                    JOIN
                        Users U ON OT.creator_user_id=U.user_id
                    WHERE
                        OT.available_course_id = :ta_course_input
                    ORDER BY OT.update_date";
            if ($limit == NULL) {
                $query = $conn->prepare($query);
            } else {
                $query .= " LIMIT :limit;";
                $query = $conn->prepare($query);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->bindParam(":ta_course_input", $teaching_assistant_id);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Query completed");
            $myTickets = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all data completed");
            return $myTickets;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get my open tickets");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

}