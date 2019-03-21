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
     */
    public function isTeachingAssistant($userId) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT COUNT(*) FROM Teaching_Assistants
            WHERE user_id = :userId;"
        );
        $query->bindParam(":userId", $userId);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        $result = $results["COUNT(*)"];
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Returns all of the teaching assistants with information about them.
     * 
     * @param $limit - (optional) A limit to the number of teaching assistants to return.
     * @return $teachingAssistants - The array of arrays for each teaching assistant.
     */
    public function getTeachingAssistants($limit=NULL) {
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
            $query->bindParam(":limit", $limit);
        }
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $teachingAssistants = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . " " . print_r($teachingAssistants,1));
        return $teachingAssistants;
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
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Teaching_Assistants (user_id, available_course_id,
             start_time_past_midnight, end_time_past_midnight) VALUES (
             :userId, :courseId, :startTime, :endTime)"
        );
        $query->bindParam(":userId", $userId);
        $query->bindParam(":courseId", $courseId);
        $query->bindParam(":startTime", $startTime);
        $query->bindParam(":endTime", $endTime);
        if ($query->execute()) {
            $query = $conn->prepare(
                "UPDATE TABLE Users SET permission_id = 2 
                 WHERE user_id = :userId"
            );
            $query->bindParam(":userId", $userId);
            if ($query->execute()) {
                return $this->SUCCESS;
            } else {
                return $this->FAILURE;
            }
        } else {
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
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "UPDATE TABLE Users SET permission_id = 1
             WHERE user_id = :userId"
        );
        $query->bindParam(":userId", $userId);
        if ($query->execute()) {
            $query = $conn->prepare(
                "DELETE FROM Teaching_Assistants
                 WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
            if ($query->execute()) {
                return $this->SUCCESS;
            } else {
                return $this->FAILURE;
            }
        } else {
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the teaching assistants online right now.
     * 
     * @return $availableTeachingAssistants - The TAs online right now.
     */
    public function getAvailableTeachingAssistants() {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT * FROM Teaching_Assistants INNER JOIN Users
             ON Teaching_Assistants.user_id = Users.user_id
             WHERE Users.online = 1;"
        );
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $availableTeachingAssistants = $query->fetchAll();
        return $availableTeachingAssistants;
    }

    /**
     * Gets all open tickets for the corresponding TA
     * @return $myTickets - open tickets for that specific TA
     */
    public function getMyOpenTickets($teaching_assistant_id) {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT open_ticket_id, course_name, OT.update_date, first_name, last_name, node_number, online, 
        description FROM Open_Tickets OT JOIN Available_Courses AC ON OT.available_course_id=AC.available_course_id
        JOIN Users U ON OT.creator_user_id=U.user_id WHERE OT.available_course_id = :ta_course_input ORDER BY OT.update_date;");
        $query->bindParam(":ta_course_input", $teaching_assistant_id);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $myTickets = $query->fetchAll();
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($openTickets,1));
        return $myTickets;
    }

}