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
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare("SELECT COUNT(*) FROM Users WHERE email = :email;");
            $query->bindParam(':email', $email);
            $query->execute();
            $results = $query->fetch(PDO::FETCH_ASSOC);
            $result = $results["COUNT(*)"];
            if ($result) {
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): User was found.");
                return TRUE;
            } else {
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): User unable to be found.");
                return FALSE;
            }
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to check if user exists");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return NULL;
        }
    }

    /**
     * Returns the user with the specific email address.
     * 
     * @param $email - The email address of the user.
     * @return $user - The array of user data.
     */
    public function getUser($email) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT * FROM Users AS U JOIN Permissions AS P
                    ON U.permission_id = P.permission_id
                    WHERE email = :email;"
            );
            $query->bindParam(":email", $email);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $user = $query->fetch();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . ": Get user by email successful");
            return $user;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get user by email");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return NULL;
        }
        
    }

    /**
     * Returns the user with the specific id.
     * 
     * @param $id - The user id of the user.
     * @return $user - The array of user data.
     */
    public function getUserById($id) {
        try{
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT * FROM Users AS U JOIN Permissions AS P
                    ON U.permission_id = P.permission_id
                    WHERE user_id = :id;"
            );
            $query->bindParam(":id", $id);
            $query->execute();
            $user = $query->fetch();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . ": Get user by id successful");
            return $user;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get user by id");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return NULL;
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
        try {
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
                $query->execute();
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Create user successful");
                return $this->SUCCESS;
            } else {
                $this->logger->logWarn(basename(__FILE__) . ":" . __FUNCTION__ . "(): User exists already");
                return $this->FAILURE;
            }
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to create user");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Delete a user from the database.
     * 
     * @param $email - The email address of the user to delete from the database.
     * @return Returns TRUE if the user was deleted, else FALSE.
     */
    public function deleteUser($email) {
        try {
            if ($this->userExists($email)) {
                $conn = $this->getConnection();
                $query = $conn->prepare("DELETE FROM Users WHERE email = :email;");
                $query->bindParam(":email", $email);
                $query->execute();
                $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Delete user successful");
                return $this->SUCCESS;
            } else {
                $this->logger->logWarn(basename(__FILE__) . ":" . __FUNCTION__ . "(): User does not exist");
                return $this->FAILURE;
            }
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to delete user");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Updates a user from the database
     * 
     * @return Returns TRUE if the user was updated, else FALSE.
     */
    public function updateUser($user_id, $firstName, $lastName, $email, $permissionID, $admin_id){
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "UPDATE Users SET 
                    email = :email,
                    first_name = :first_name, 
                    last_name = :last_name,
                    permission_id = :permission_id
                    WHERE user_id = :user_id;"
            );
            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":email", $email);
            $query->bindParam(":first_name", $firstName);
            $query->bindParam(":last_name", $lastName);
            $query->bindParam(":permission_id", $permissionID);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Admin: " . $admin_id . " has Updated User " . $user_id);
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Admin: " . $admin_id . " unable to update User " . $user_id);
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Returns all of the users.
     * 
     * @param $limit - (optional) A limit to the number of users to get.
     * @return $users - All of the users from the Users table.
     */
    public function getUsers($limit=NULL){
        try {
            $conn = $this->getConnection();
            $query = "SELECT * FROM Users AS U JOIN Permissions AS P
                    ON U.permission_id = P.permission_id";
            if ($limit == NULL) {
                $query = $conn->prepare($query);
            } else {
                $query .= " LIMIT :limit;";
                $query = $conn->prepare($query);
                $query->bindParam(":limit", $limit, PDO::PARAM_INT);
            }
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $users = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all users successful");
            return $users;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get all users");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
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
            $onlineStatus = $query->fetch()[0];
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Online status found: " . $onlineStatus);
            switch ($onlineStatus) {
                case 0:
                    return "OFFLINE";
                case 1:
                    return "ONLINE";
                case 2:
                    return "AWAY";
                default:
                    return "N/A";
            }
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get online status");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Returns all of the users that are online.
     * @return $users - All returned users.
     */
    public function getOnlineUsers(){
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "SELECT * FROM Users AS U JOIN Permissions AS P
                ON U.permission_id = P.permission_id
                WHERE U.online != 0;"
            );
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $users = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all online users successful");
            return $users;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get all online users");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return $this->FAILURE;
        }
    }

    /**
     * Sets the online flag to 1 (online) for the user.
     * 
     * @param $userEmail - The email address of the user to change to online.
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    public function setUserOnline($userEmail) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "UPDATE Users SET online = 1, update_date = CURRENT_TIMESTAMP
                WHERE email = :email;"
            );
            $query->bindParam(":email", $userEmail);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Set user online successful");
            return $this->SUCCESS;
        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to set user online");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
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
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "UPDATE Users SET online = 0 WHERE email = :email;"
            );
            $query->bindParam(":email", $userEmail);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Set the user offline");
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to set user offline");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
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
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "UPDATE Users SET online = 2 WHERE email = :email;"
            );
            $query->bindParam(":email", $userEmail);
            $query->execute();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Set the user to away");
            return $this->SUCCESS;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to set user away");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . ": " . $e->getMessage());
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
        try {
            $conn = $this->getConnection();
            $query = " SELECT
                    Users.user_id,
                    Users.first_name,
                    MIN(Open_Tickets.update_date)
                FROM Users INNER JOIN Open_Tickets
                ON Users.user_id = Open_Tickets.creator_user_id ";
            
            if ($this->USE_ONLINE_ONLY) {
                $query .= " WHERE Users.online != 0 ";
            }

            $query .= "
                GROUP BY Users.user_id
                ORDER BY MIN(Open_Tickets.update_date) ASC;";
            $query = $conn->prepare($query);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            $query->execute();
            $openTicketOrder = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all open tickets");

            // Attempt to find the first occurence of the user's id
            for ($i = 0; $i < count($openTicketOrder); $i++) {
                if ($openTicketOrder[$i]["user_id"] == $userId) {
                    $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Found user queue number at row " . $i);
                    return ($i + 1);
                }
            }

            $this->logger->logInfo(basename(__FILE__) . ":" . __FUNCTION__ . "(): User has no open tickets");
            return -1;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to get user's queue number");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return -1;
        }
    }

    /**
     * Returns the user's open tickts.
     * 
     * @param $userEmail - The user's email to search for open tickts.
     * @return $openTickets - The open tickets for that user.
     */
    public function getUserOpenTickts($userEmail) {
        try {
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
            $query->execute();
            $openTickets = $query->fetchAll();
            $this->logger->logDebug(basename(__FILE__) . ":" . __FUNCTION__ . "(): Fetch all open tickets for user");
            return $openTickets;

        } catch (Exception $e) {
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): Unable to fetch user's open tickets");
            $this->logger->logError(basename(__FILE__) . ":" . __FUNCTION__ . "(): " . $e->getMessage());
            return Array();
        }
    }

}

?>