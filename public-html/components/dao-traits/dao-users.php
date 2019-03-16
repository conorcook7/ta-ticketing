<?php
/**
 * User trait to contain the dao functions for the users.
 * 
 * Traits are used to abstract the functions out of a class. The class can
 * then require the file and use this trait.
 */
trait DaoUsers {

    /**
     * Checks if a user exists in the database already.
     * 
     * @param $email - The email of the user to check.
     * @return Returns TRUE if the user exists, else FALSE.
     */
    public function userExists($email){
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT COUNT(*) FROM Users WHERE email = :email;");
        $query->bindParam(':email', $email);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        $result = $results["COUNT(*)"];
        if ($result) {
            $this->logger->logDebug(__FUNCTION__ . ": User was found.");
            return TRUE;
        } else {
            $this->logger->logDebug(__FUNCTION__ . ": User unable to be found.");
            return FALSE;
        }
    }

    /**
     * Returns the user with the specific email address.
     * 
     * @param $email - The email address of the user.
     * @return $user - The array of user data.
     */
    public function getUser($email) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT * FROM Users AS U JOIN Permissions AS P
                ON U.permission_id = P.permission_id
                WHERE email = :email;"
        );
        $query->bindParam(":email", $email);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        try {
            if ($query->execute()) {
                $this->logger->logDebug(__FUNCTION__ . ": Get user successful");
                $user = $query->fetch();
                return $user;
            } else {
                $this->logger->logError(__FUNCTION__ . "Query returned bad status upon completion");
                return Array();
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . " " . $e->getMessage());
            return Array();
        }
        
    }

    /**
     * Create a user if they do not exist in the database.
     * 
     * @param $email - The email address of the user to create.
     * @param $firstName - The first name of the user if given, else NULL.
     * @param $lastName - The last name of the user if given, else NULL.
     * @return Returns TRUE if the user was created, else FALSE
     */
    public function createUser($email, $firstName=NULL, $lastName=NULL) {
        $exists = $this->userExists($email);
        if (!$exists) {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Users (email, first_name, last_name) " .
                "VALUES (:email, :firstName, :lastName);"
            );
            $query->bindParam(":email", $email);
            $query->bindParam(":firstName", $firstName);
            $query->bindParam(":lastName", $lastName);
            $status = $query->execute();
            if ($status) {
                $this->logger->logDebug(__FUNCTION__ . ": Get user successful");
                return $this->SUCCESS;
            }
        }
        return $this->FAILURE;
    }

    /**
     * Delete a user from the database.
     * 
     * @param $email - The email address of the user to delete from the database.
     * @return Returns TRUE if the user was deleted, else FALSE.
     */
    public function deleteUser($email) {
        if ($this->userExists($email)) {
            $conn = $this->getConnection();
            $query = $conn->prepare("DELETE FROM Users WHERE email = :email;");
            $query->bindParam(":email", $email);
            $status = $query->execute();
            if (status) {
                return $this->SUCCESS;
            }
        }
        return $this->FAILURE;
    }

    /**
     * Returns all of the users.
     * @return $users - All of the users from the Users table.
     */
    public function getUsers(){
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT * FROM Users AS U JOIN Permissions AS P
             ON U.permission_id = P.permission_id;"
        );
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $users = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__);
        return $users;
    }

    /**
     * Retuns the online flag from the database
     * 
     * @param $userEmail - The email address of the user to check
     * @return $onlineStatus - The string version of the online status
     */
    public function getOnlineStatus($userEmail) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT online FROM Users WHERE email = :email;");
            $query->bindParam(":email", $userEmail);
            $status = $query->execute();
            if ($status) {
                $onlineStatus = $query->fetch();
                switch ($onlineStatus) {
                    case "0":
                        return "OFFLINE";
                    case "1":
                        return "ONLINE";
                    case "2":
                        return "AWAY";
                    default:
                        return "N/A";
                }
            } else {
                $this->logger->logError(__FUNCTION__ . ": Unable to fetch online status");
                return $this->FAILURE;
            }
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Returns all of the users that are online.
     * @return $users - All returned users.
     */
    public function getOnlineUsers(){
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT * FROM Users AS U JOIN Permissions AS P
             ON U.permission_id = P.permission_id
             WHERE U.online != 0;"
        );
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $users = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__);
        return $users;
    }

    /**
     * Sets the online flag to 1 (online) for the user.
     * 
     * @param $userEmail - The email address of the user to change to online.
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    public function setUserOnline($userEmail) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "UPDATE Users SET online = 1 WHERE email = :email;"
        );
        $query->bindParam(":email", $userEmail);
        try {
            $status = $query->execute();
            return $status;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Sets the online flag to 0 (offline) fo rthe user.
     * 
     * @param $userEmail - The email address of the user to change to offline.
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    public function setUserOffline($userEmail) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "UPDATE Users SET online = 0 WHERE email = :email;"
        );
        $query->bindParam(":email", $userEmail);
        try {
            $status = $query->execute();
            return $status;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Sets the online flag to 2 (away) for the user.
     * 
     * @param $userEmail - The email address of the user to change to away.
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    public function setUserAway($userEmail) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "UPDATE Users SET online = 2 WHERE email = :email;"
        );
        $query->bindParam(":email", $userEmail);
        try {
            $status = $query->execute();
            return $status;
        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Returns the place in line that the user currently is.
     * 
     * @param $userId - The user ID of the user to check for.
     * @return Returns the place the user currently is, else -1.
     */
    public function getQueueNumber($userId) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT Users.user_id, Users.first_name, MIN(Open_Tickets.update_date)
             FROM Users INNER JOIN Open_Tickets
             ON Users.user_id = Open_Tickets.creator_user_id
             WHERE Users.online = 1
             GROUP BY Users.user_id
             ORDER BY MIN(Open_Tickets.update_date) ASC;"
        );
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $openTicketOrder = $query->fetchAll();
        for ($i = 0; $i < count($openTicketOrder); $i++) {
            if ($openTicketOrder[$i]["user_id"] == $userId) {
                return ($i + 1);
            }
        }
        return -1;
    }

    /**
     * Returns the user's open tickts.
     * 
     * @param $userEmail - The user's email to search for open tickts.
     * @return $openTickets - The open tickets for that user.
     */
    public function getUserOpenTickts($userEmail) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT
                OT.open_ticket_id,
                OT.description,
                OT.create_date,
                AC.course_number
            FROM
                Open_Tickets AS OT
            JOIN
                Available_Courses AS AC ON OT.available_course_id = AC.available_course_id
            JOIN
                Users AS U ON OT.creator_user_id = U.user_id
            WHERE
                U.email = :userEmail
            ;"
        );
        $query->bindParam(":userEmail", $userEmail);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        try {
            if (!$query->execute()) {
                $this->logger->logError(__FUNCTION__ . ": Unable to select all open tickets for user.");
                return Array();
            }
            $openTickets = $query->fetchAll();
            return $openTickets;

        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e->getMessage());
            return Array();
        }
    }

    /**
     * Log out the users that have an away flag (i.e., online = 2).
     * 
     * @param $tolerance - The amount of time (in seconds) that need to have passed to log out the user.
     * @return Returns TRUE if the query updated users, else FALSE.
     */
    public function logoutAwayUsers($tolerance) {
        try {
            // Get all of the users with away status
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT * FROM Users WHERE online = 2;");
            $status = $query->execute();
            if (!$status) {
                $this->logger->logError(__FUNCTION__ . ": Unable to get users that are away.");
                return $this->FAILURE;
            }
            $awayUsers = $query->fetchAll();

            // Compare each users update time agains the tolerance
            $now = new DateTime("now", new DateTimeZone("America/Boise"));

            foreach ($awayUsers as $user) {
                $updateTime = new DateTime($user["update_date"]);
                $expirationTime = $updateTime->getTimestamp() + $tolerance;

                // If it is past the expiration time
                if ($now->getTimestamp() >= $expirationTime) {
                    $query = $conn->prepare(
                        "UPDATE Users SET online = 0 WHERE email = :email;"
                    );
                    $query->bindParam(":email", $user["email"]);
                    $status = $query->execute();
                    if (!$status) {
                        $this->logger->logError(__FUNCTION__ . ": unable to logout user " . $user["user_id"]);
                    }
                }
            }

            // Return that the method was able to complete
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(__FUNCTION__ . ": " . $e);
            return $this->FAILURE;
        }
    }

}

?>