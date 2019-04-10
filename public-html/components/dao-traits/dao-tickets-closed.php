<?php
/**
 * Closed tickets trait to contain the dao functions for the closed tickets.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoTicketsClosed {

    /**
     * Get all of the closed tickes.
     * 
     * @param $limit - (optional) A limit to the number of tickets to get.
     * @return $closedTickets - The array of arrays of closed tickets information.
     */
    public function getClosedTickets($limit=NULL) {
        try {
            $conn = $this->getConnection();
            $query = "SELECT
                    CT.closed_ticket_id,
                    CT.description,
                    CT.node_number,
                    CT.room_number,
                    CT.create_date,
                    CT.update_date,
                    CT.closing_description,

                    AC.available_course_id,
                    AC.course_name,
                    AC.course_number,
                    AC.course_description,

                    Students.user_id AS student_user_id,
                    Students.permission_id AS student_permission_id,
                    Students.permission_name AS student_permission_name,
                    Students.online AS student_online,
                    Students.email AS student_email,
                    Students.first_name AS student_first_name,
                    Students.last_name AS student_last_name,

                    Ta.user_id AS ta_user_id,
                    Ta.permission_id AS ta_permission_id,
                    Ta.permission_name AS ta_permission_name,
                    Ta.online AS ta_online,
                    Ta.email AS ta_email,
                    Ta.first_name AS ta_first_name,
                    Ta.last_name AS ta_last_name
                FROM
                    Closed_Tickets AS CT
                JOIN
                    Available_Courses AS AC
                ON CT.available_course_id = AC.available_course_id
                JOIN
                    (SELECT
                        Permissions.permission_id,
                        Permissions.permission_name,
                        user_id,
                        online,
                        email,
                        first_name,
                        last_name
                    FROM Users JOIN Permissions
                    ON Users.permission_id = Permissions.permission_id
                    ) AS Students
                ON CT.creator_user_id = Students.user_id
                JOIN
                    (SELECT
                        Permissions.permission_id,
                        Permissions.permission_name,
                        user_id,
                        online,
                        email,
                        first_name,
                        last_name
                    FROM Users JOIN Permissions
                    ON Users.permission_id = Permissions.permission_id
                    ) AS Ta
                ON CT.closer_user_id = Ta.user_id
                ORDER BY CT.update_date";
            if ($limit == NULL) {
                $query = $conn->prepare($query);
            } else {
                $query .= " LIMIT :limit;";
                $query = $conn->prepare($query);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Query completed");
            $closedTickets = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all data completed");
            return $closedTickets;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get closed tickets");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Opens a closed ticket by moving it from the closed table to the open ticket table.
     * 
     * @param $closedTicketId - The ticket id to be opened again.
     * @param $openerTicketId - The person that opened the ticket again.
     * @return Returns TRUE if the ticket was able to be opened again, else FALSE.
     */
    public function openClosedTicket($closedTicketId, $openerUserId) {
        try {
            $conn = $this->getConnection();
            
            // Get the ticket data to insert into the closed tickets table.
            $query = $conn->prepare(
                "SELECT * FROM Closed_Tickets WHERE closed_ticket_id = :closedTicketId;"
            );
            $query->bindParam(":closedTicketId", $closedTicketId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $ticket = $query->fetch();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Obtained ticket data");

            if (!$ticket) {
                $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to fetch select data for closed ticket.");
                return $this->FAILURE;
            }

            // Insert the ticket data into the open tickets table.
            $query = $conn->prepare(
                "INSERT INTO Open_Tickets (available_course_id, creator_user_id,
                node_number, opener_user_id, description, room_number) VALUES (
                :availableCourseId, :userId, :nodeNumber, :openerUserId,
                :description, :roomNumber);"
            );
            $query->bindParam(":availableCourseId", $ticket["available_course_id"]);
            $query->bindParam(":userId", $ticket["creator_user_id"]);
            $query->bindParam(":nodeNumber", $ticket["node_number"]);
            $query->bindParam(":openerUserId", $openerUserId);
            $query->bindParam(":description", $ticket["description"]);
            $query->bindParam(":roomNumber", $ticket["room_number"]);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Inserted data into open tickets");
        
            // Delete the open ticket from the open ticket table.
            $query = $conn->prepare(
                "DELETE FROM Closed_Tickets WHERE closed_ticket_id = :closedTicketId ;"
            );
            $query->bindParam(":closedTicketId", $closedTicketId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Deleted closed ticket");
        
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to open the closed ticket");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Return the closed ticket by the id
     * 
     * @param $closedTicketId - The id of the ticket to get
     */
    public function getClosedTicketById($closedTicketId) {
        try {
            $conn = $this->getConnection();
            
            // Get the ticket data to insert into the closed tickets table.
            $query = $conn->prepare(
                "SELECT * FROM Closed_Tickets WHERE closed_ticket_id = :closedTicketId;"
            );
            $query->bindParam(":closedTicketId", $closedTicketId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $ticket = $query->fetch();
            return $ticket;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get the closed ticket");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

}