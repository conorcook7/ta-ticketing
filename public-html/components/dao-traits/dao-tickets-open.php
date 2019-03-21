<?php
/**
 * Open tickets trait to contain the dao functions for the open tickets.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoTicketsOpen {

    /**
     * Get all of the open ticket.
     * 
     * @param $limit - (optional) A limit to the number of tickets to get.
     * @return $openTickets - The array of arrays of open tickets information.
     */
    public function getOpenTickets($limit=NULL) {
        $conn = $this->getConnection();
        $query ="SELECT
                open_ticket_id,
                creator_user_id,
                course_name,
                course_number,
                OT.update_date,
                OT.available_course_id,
                first_name,
                last_name,
                node_number,
                online, 
                description
            FROM Open_Tickets OT
            JOIN Available_Courses AC ON OT.available_course_id=AC.available_course_id
            JOIN Users U ON OT.creator_user_id=U.user_id
            ORDER BY OT.update_date
            ";
        if ($limit == NULL) {
            $query = $conn->prepare($query);
        } else {
            $query .= " LIMIT :limit;";
            $query = $conn->prepare($query);
            $query->bindParam(":limit", $limit);
        }
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $openTickets = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . ": First open ticket: " . print_r($openTickets[0],1));
        return $openTickets;
    }

    /**
     * Create a new open ticket to store in the database.
     * 
     * @param $availableCourseId - The course id that was selected.
     * @param $userId - The user id that created the ticket.
     * @param $nodeNumber - The node number where the ticket was created.
     * @param $openerUserId - The user id of the person who re-openned the ticket.
     * @param $description - The description that was typed in the ticket.
     * @param $roomNumber - The room number that the ticket was submitted from.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createTicket($availableCourseId, $userId, $nodeNumber, $description) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Open_Tickets (available_course_id, creator_user_id,
             node_number, description) VALUES (
             :availableCourseId, :userId, :nodeNumber, :description);"
        );
        $query->bindParam(":availableCourseId", $availableCourseId);
        $query->bindParam(":userId", $userId);
        $query->bindParam(":nodeNumber", $nodeNumber);
        $query->bindParam(":description", $description);
        try {
            $status = $query->execute();
            if ($status) {
                $this->logger->logDebug(__FUNCTION__ . ": Created new ticket.");
                return $this->SUCCESS;
            } else {
                $this->logger->logError(__FUNCTION__ . ": Unable to create new ticket");
                return $this->FAILURE;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
        $this->logger->logError(__FUNCTION__ . ": Unable to create new ticket");
        return $this->FAILURE;
    }

    /**
     * Deletes a ticket from the open tickets table
     * 
     * @param $openTicketId - The open ticket id that is to be deleted.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteTicket($openTicketId) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "DELETE FROM Open_Tickets WHERE open_ticket_id = :openTicketId;"
        );
        $query->bindParam(":openTicketId", $openTicketId);
        if ($query->execute()) {
            return $this->SUCCESS;
        }
        return $this->FAILURE;
    }

    /**
     * Moves a ticket from the open ticket table to the closed ticket table.
     * 
     * @param $openTicketId - The ticket id that is to be moved.
     * @param $closerUserId - The user id that closed the ticket.
     * @return Returns TRUE if the ticket was closed, else FALSE.
     */
    public function closeTicket($openTicketId, $closerUserId) {
        $conn = $this->getConnection();
        
        // Get the ticket data to insert into the closed tickets table.
        $query = $conn->prepare(
            "SELECT * FROM Open_Tickets WHERE open_ticket_id = :openTicketId;"
        );
        $query->bindParam(":openTicketId", $openTicketId);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $status = $query->execute();
        if (!$status) {
            $this->logger->logError(__FUNCTION__ . ": Unable to get open ticket data.");
            return $this->FAILURE;
        }
        $ticket = $query->fetch();
        if (!isset($ticket)) {
            $this->logger->logError(__FUNCTION__ . ": Unable to fetch the open ticket data.");
            return $this->FAILURE;
        }

        // Insert the ticket data into the closed tickets table.
        $query = $conn->prepare(
            "INSERT INTO Closed_Tickets (available_course_id, creator_user_id,
             node_number, closer_user_id, description, room_number) VALUES (
             :availableCourseId, :userId, :nodeNumber, :closerUserId,
             :description, :roomNumber);"
        );
        $query->bindParam(":availableCourseId", $ticket["available_course_id"]);
        $query->bindParam(":userId", $ticket["creator_user_id"]);
        $query->bindParam(":nodeNumber", $ticket["node_number"]);
        $query->bindParam(":closerUserId", $closerUserId);
        $query->bindParam(":description", $ticket["description"]);
        $query->bindParam(":roomNumber", $ticket["room_number"]);
        $status = $query->execute();
        if (!$status) {
            $this->logger->logError(__FUNCTION__ . ": Unable to insert into closed tickets.");
            return $this->FAILURE;
        }
        
        // Delete the open ticket from the open ticket table.
        $query = $conn->prepare(
            "DELETE FROM Open_Tickets WHERE open_ticket_id = :openTicketId;"
        );
        $query->bindParam(":openTicketId", $openTicketId);
        $status = $query->execute();
        if ($status) {
            return $this->SUCCESS;
        }
        $this->logger->logError(__FUNCTION__ . ": Unable to delete from open tickets.");
        return $this->FAILURE;
    }

}