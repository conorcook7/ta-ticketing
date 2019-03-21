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
    public function getClosedTickets() {
        $conn = $this->getConnection();
        $query = "SELECT
                CT.closed_ticket_id,
                CT.description,
                CT.node_number,
                CT.room_number,
                CT.create_date,
                CT.update_date,

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
            $query->bindParam(":limit", $limit);
        }
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $status = $query->execute();
        if (!$status) {
            $this->logger->logError(__FUNCTION__ . ": Unable to get all closed tickets.");
        }
        $closedTickets = $query->fetchAll();
        return $closedTickets;
    }

    /**
     * Opens a closed ticket by moving it from the closed table to the open ticket table.
     * 
     * @param $closedTicketId - The ticket id to be opened again.
     * @param $openerTicketId - The person that opened the ticket again.
     * @return Returns TRUE if the ticket was able to be opened again, else FALSE.
     */
    public function openClosedTicket($closedTicketId, $openerUserId) {
        $conn = $this->getConnection();
        
        // Get the ticket data to insert into the closed tickets table.
        $query = $conn->prepare(
            "SELECT * FROM Closed_Tickets WHERE closed_ticket_id = :closedTicketId;"
        );
        $query->bindParam(":closedTicketId", $closedTicketId);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        try {
            $status = $query->execute();
            if (!$status) {
                $this->logger->logError(__FUNCTION__ . ": Unable to select closed ticket.");
                return $this->FAILURE;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
        }
        $ticket = $query->fetch();
        if (!isset($ticket)) {
            $this->logger->logError(__FUNCTION__ . ": Unable to fetch select data for closed ticket.");
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
        try {
            $status = $query->execute();
            if (!$status) {
                $this->logger->logError(__FUNCTION__ . ": Unable to insert the data into open tickets.");
                return $this->FAILURE;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
        
        // Delete the open ticket from the open ticket table.
        $query = $conn->prepare(
            "DELETE FROM Closed_Tickets WHERE closed_ticket_id = :closedTicketId ;"
        );
        $query->bindParam(":closedTicketId", $closedTicketId);
        try {
            $status = $query->execute();
            $this->logger->logDebug(__FUNCTION__ . ": status = " . $status);
            if ($status) {
                return $this->SUCCESS;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
        $this->logger->logError(__FUNCTION__ . ": Ran off the end of the function");
        return $this->FAILURE;
    }

}