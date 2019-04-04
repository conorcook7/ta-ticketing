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
        try {
            $conn = $this->getConnection();
            $query ="SELECT
                    open_ticket_id,
                    creator_user_id,
                    opener_user_id,
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
                ";
            if ($this->USE_ONLINE_ONLY) {
                $query .= " WHERE online != 0 ";
            }
            $query .= " ORDER BY OT.update_date ";
            if ($limit == NULL) {
                $query = $conn->prepare($query);
            } else {
                $query .= " LIMIT :limit;";
                $query = $conn->prepare($query);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $openTickets = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all open tickets completed");
            return $openTickets;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get open tickets");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
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
        try {
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
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Created new ticket.");
            return $this->SUCCESS;
            
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to create ticket");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Deletes a ticket from the open tickets table
     * 
     * @param $openTicketId - The open ticket id that is to be deleted.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteTicket($openTicketId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "DELETE FROM Open_Tickets WHERE open_ticket_id = :openTicketId;"
            );
            $query->bindParam(":openTicketId", $openTicketId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Deleted open ticket");
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to delete open ticket");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Moves a ticket from the open ticket table to the closed ticket table.
     * 
     * @param $openTicketId - The ticket id that is to be moved.
     * @param $closerUserId - The user id that closed the ticket.
     * @return Returns TRUE if the ticket was closed, else FALSE.
     */
    public function closeTicket($openTicketId, $closerUserId, $textInput) {
        try {
            $conn = $this->getConnection();
            
            // Get the ticket data to insert into the closed tickets table.
            $query = $conn->prepare(
                "SELECT * FROM Open_Tickets WHERE open_ticket_id = :openTicketId;"
            );
            $query->bindParam(":openTicketId", $openTicketId);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $ticket = $query->fetch();
            if (!isset($ticket)) {
                $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . ": Unable to fetch the open ticket data.");
                return $this->FAILURE;
            }
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Obtained open ticket data.");

            // Insert the ticket data into the closed tickets table.
            $query = $conn->prepare(
                "INSERT INTO Closed_Tickets (available_course_id, creator_user_id,
                node_number, closer_user_id, description, closing_description, room_number) VALUES (
                :availableCourseId, :userId, :nodeNumber, :closerUserId,
                :description, :closing_description, :roomNumber);"
            );
            $query->bindParam(":availableCourseId", $ticket["available_course_id"]);
            $query->bindParam(":userId", $ticket["creator_user_id"]);
            $query->bindParam(":nodeNumber", $ticket["node_number"]);
            $query->bindParam(":closerUserId", $closerUserId);
            $query->bindParam(":description", $ticket["description"]);
            $query->bindParam(":closing_description", $textInput);
            $query->bindParam(":roomNumber", $ticket["room_number"]);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Insert the open ticket data to closed tickets");
            
            // Delete the open ticket from the open ticket table.
            $query = $conn->prepare(
                "DELETE FROM Open_Tickets WHERE open_ticket_id = :openTicketId;"
            );
            $query->bindParam(":openTicketId", $openTicketId);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Deleted open ticket from table");
            
            return $this->SUCCESS;
            
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to close the open ticket");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Get the queue number for this ticket.
     * 
     * @param $openTicketId - The ticket id to check for the queue number
     * @return $queueNum - The queue number for this ticket
     */
    public function ticketQueueNumber($openTicketId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT open_ticket_id FROM Open_Tickets ORDER BY update_date ASC;"
            );
            $query->execute();
            $queue = $query->fetchAll();
            for ($i = 0; $i < sizeof($queue); $i++) {
                if ($queue[$i]["open_ticket_id"] == $openTicketId) {
                    $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): found queue number at row " . $i);
                    return ($i + 1);
                }
            }
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to find queue nubmer by comparison.");
            return -1;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get ticket queue number");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return -1;
        }
    }

}