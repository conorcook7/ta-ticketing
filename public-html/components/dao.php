<?php

require_once 'KLogger.php';

/**
 * The data access object (Dao) for the website. This object uses a standard user for the local mysql instance.
 * The user is only created in the Dummy_TA_Ticketing database, it will have to be added manually to the production DB.
 */
class Dao {
  
    private $SUCCESS = TRUE;
    private $FAILURE = FALSE;

    private $db;
    private $user = "ta-ticketing";
    private $pass = "34$5iu98&7o7%76d4Ss35";

    protected $logger;

    /**
     * Constructor for the Dao object.
     * 
     * @param $database - The database name to connect to.
     */
    public function __construct($database) {
        $this->logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
        $this->db = $database;
    }
  
    /**
     * Attempts to connect to the local MySQL instance with the user ta-ticketing.
     * 
     * @return $conn - The connection to the localhost MySQL database.
     */
    public function getConnection() {
        try{
            $conn = new PDO("mysql:host=localhost;dbname={$this->db}", $this->user, $this->pass);
            $this->logger->logDebug("Established a database connection.");
            return $conn;
        } catch (Exception $e) {
            echo "connection failed: " . $e->getMessage();
            $this->logger->logFatal("The database connection failed.");
            return $this->FAILURE;
        }
    }

    /**
     * Hashes the password with a salt using the MD5 encryption method.
     * 
     * @param $password - The password to hash.
     * @return Returns the hashed password.
     */
    private function hashPassword($password) {
        $salt = '!@%#^^%*&;rweltkjusofd;iajg168152410';
        return md5($password . $salt);
    }

    /**
     * Verifies that the password contains the following criteria:
     *
     *      - Contains at least 1 upper-case letter.
     *      - Contains at least 1 lower-case letter.
     *      - Contains at least 1 digit.
     * 
     * @param $password - The password to verify.
     * @return Returns TRUE if the password matches the criteria, else FALSE.
     */
    public function verifyPassword($password){
        $regex='/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
        if (preg_match($regex, $password)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getLogs() { }
    
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
            $this->logger->logDebug("User was found.");
            return TRUE;
        } else {
            $this->logger->logDebug("User unable to be found.");
            return FALSE;
        }
    }

    /**
     * Returns the user with the specific email address.
     * 
     * @param $email - The email address of the user.
     * @return $user - The array of user data.
     */
    public function getUser($email=NULL, $userId=NULL) {
        $conn = $this->getConnection();
        if ($email !== NULL) {
            $query = $conn->prepare(
                "SELECT * FROM Users AS U JOIN Permissions AS P
                 ON U.permission_id = P.permission_id
                 WHERE email = :email;"
            );
            $query->bindParam(":email", $email);
        } else if ($userId !== NULL) {
            $query = $conn->prepare(
                "SELECT * FROM Users AS U JOIN Permissions AS P
                 ON U.permission_id = P.permission_id
                 WHERE user_id = :userId;"
            );
            $query->bindParam(":userId", $userId);
        } else {
            return Array();
        }
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user;
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
            if (status) {
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
            $this->logger->logError($e->getMessage());
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
            $this->logger->logError($e->getMessage());
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
     * @return $teachingAssistants - The array of arrays for each teaching assistant.
     */
    public function getTeachingAssistants() {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT * FROM Teaching_Assistants AS TA JOIN Users AS U
             ON TA.user_id = U.user_id;"
        );
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
     * Get all of the available permission levels.
     * @return $permissionLevels - The array of arrays of permission levels information.
     */
    public function getPermissionLevels() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Permissions;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $permissionLevels = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . " " . print_r($permissionLevels,1));
        return $permissionLevels;
    }

    /**
     * Attempts to create a permission level. The method will fail if the
     * permisson name already exists in the database.
     * 
     * @param $permissionName - The unique permission name to add to the database.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createPermissionsLevel($permissionName) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Permissions (permission_name)
             VALUES (:permissionName);"
        );
        $query->bindParam(":permissionName", $permissionName);
        if ($query->execute()) {
            return $this->SUCCESS;
        } else {
            return $this->FAILURE;
        }
    }

    /**
     * Delete a permission based on id or name.
     * 
     * @param $permissionId - The id of the permission to delete.
     * @param $permissionName - The name of the permission to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deletePermissionsLevel($permissionId=NULL, $permissionName=NULL) {
        assert($permissionId !== NULL || $permissionName !== NULL);
        $conn = $this->getConnection();
        if ($permissionId !== NULL) {
            $query = $conn->prepare(
                "DELETE FROM Permissions WHERE permission_id = :permissionId"
            );
            $query->bindParam(":permissionId", $permissionId);
        } else if ($permissionName !== NULL) {
            $query = $conn->prepare(
                "DELETE FROM Permissions WHERE permission_name = :permissionName"
            );
            $query->bindParam(":permissionName", $permissionName);
        } else {
            return $this->FAILURE;
        }
        if ($query->execute()) {
            return $this->SUCCESS;
        } else {
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the open ticket.
     * 
     * @return $openTickets - The array of arrays of open tickets information.
     */
    public function getOpenTickets() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT open_ticket_id, course_name, OT.update_date, OT.available_course_id, first_name, last_name, node_number, online, 
        description FROM Open_Tickets OT JOIN Available_Courses AC ON OT.available_course_id=AC.available_course_id
        JOIN Users U ON OT.creator_user_id=U.user_id ORDER BY OT.update_date;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $openTickets = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . ": First open ticket: " . print_r($openTickets[0],1));
        return $openTickets;
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
    public function createTicket($availableCourseId, $userId, $nodeNumber,
                                 $openerUserId=NULL, $description=NULL,
                                 $roomNumber=NULL) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Open_Tickets (available_course_id, creator_user_id,
             node_number, opener_user_id, description, room_number) VALUES (
             :availableCourseId, :userId, :nodeNumber, :openerUserId,
             :description, :roomNumber);"
        );
        $query->bindParam(":availableCourseId", $availableCourseId);
        $query->bindParam(":userId", $userId);
        $query->bindParam(":nodeNumber", $nodeNumber);
        $query->bindParam(":openerUserId", $openerUserId);
        $query->bindParam(":description", $description);
        $query->bindParam(":roomNumber", $roomNumber);
        if ($query->execute()) {
            return $this->SUCCESS;
        } else {
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
        if (!$query->execute()) {
            return $this->FAILURE;
        }
        $ticket = $query->fetch();
        if (!isset($ticket)) {
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
        if (!$query->execute()) {
            return $this->FAILURE;
        }
        
        // Delete the open ticket from the open ticket table.
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
     * Get all of the closed tickes.
     * @return $closedTickets - The array of arrays of closed tickets information.
     */
    public function getClosedTickets() {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "SELECT
                CT.closed_ticket_id,
                CT.description,
                CT.node_number,
                CT.room_number,
                CT.create_date,
                CT.update_date,

                AC.available_course_id,
                AC.course_name,
                AC.course_number,
                AC.section,

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
            ORDER BY CT.update_date
            ;"
        );
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $closedTickets = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__);
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
        if (!$query->execute()) {
            return $this->FAILURE;
        }
        $ticket = $query->fetch();
        if (!isset($ticket)) {
            return $this->FAILURE;
        }

        // Insert the ticket data into the closed tickets table.
        $query = $conn->prepare(
            "INSERT INTO Open_Tickets (available_course_id, creator_user_id,
             node_number, opener_user_id, description, room_number) VALUES (
             :availableCourseId, :userId, :nodeNumber, :openerUserId,
             :description, :roomNumber);"
        );
        $query->bindParam(":availableCourseId", $ticket["availableCourseId"]);
        $query->bindParam(":userId", $ticket["creator_user_id"]);
        $query->bindParam(":nodeNumber", $ticket["node_number"]);
        $query->bindParam(":openerUserId", $openerUserId);
        $query->bindParam(":description", $ticket["description"]);
        $query->bindParam(":roomNumber", $ticket["room_number"]);
        if (!$query->execute()) {
            return $this->FAILURE;
        }
        
        // Delete the open ticket from the open ticket table.
        $query = $conn->prepare(
            "DELETE FROM Closed_Tickets WHERE closed_ticket_id = :closedTicketId;"
        );
        $query->bindParam(":closedTicketId", $closedTicketId);
        if ($query->execute()) {
            return $this->SUCCESS;
        }
        return $this->FAILURE;
    }

    /**
     * Get the available course by name, number, or id.
     * @param $courseId - The course id to search for.
     * @param $courseNumber - The course number to search for.
     * @param $courseName - The course name to search for.
     * @return $availableCourse - The array of course information, else and empty array.
     */
    public function getAvailableCourse($courseId=NULL, $courseNumber=NULL, $courseName=NULL) {
        assert($courseId !== NULL || $courseNumber !== NULL || $courseName !== NULL);
        $conn = $this->getConnection();
        if ($courseId != NULL) {
            $query = $conn->prepare("SELECT * FROM Available_Courses WHERE course_id = :courseId;");
            $query->bindParam(":courseId", $courseId);

        } else if ($courseNumber != NULL) {
            $query = $conn->prepare("SELECT * FROM Available_Courses WHERE course_number = :courseNumber;");
            $query->bindParam(":courseNumber", $courseNumber);

        } else if ($courseName != NULL) {
            $query = $conn->prepare("SELECT * FROM Available_Courses WHERE course_name = :courseName;");
            $query->bindParam(":courseName", $courseName);

        } else {
            return Array();
        }
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $availableCourse = $query->fetch(PDO::FETCH_ASSOC);
        $this->logger->logDebug(__FUNCTION__ . " " . print_r($availableCourses,1));
        return $availableCourse;
    }

    /**
     * Creates an available course to select from in the UI.
     * 
     * @param $courseNumber - The string version of the course number.
     * @param $courseName - The name of the course.
     * @param $courseSection - The section of the course.
     */
    public function createAvailableCourse($courseNumber, $courseName=NULL, $courseSection=NULL) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Available_Courses (course_number, course_name, section)
             VALUES (:courseNumber, :courseName, :courseSection);"
        );
        $query->bindParam(":courseNumber", $courseNumber);
        $query->bindParam(":courseName", $courseName);
        $query->bindParam(":courseSection", $courseSection);
        if ($query->execute()) {
            return $this->SUCCESS;
        }
        return $this->FAILURE;
    }

    /**
     * Attempts to delete a course from the database.
     * 
     * @param $courseId - The course_id corresponding to the row to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteAvailableCourse($courseId) {
        $conn = $this->getConnection();
        $query = $conn->prepare("DELETE FROM Available_Courses WHERE course_id = :courseId;");
        $query->bindParam(":courseId", $courseId);
        if ($query->execute()) {
            return $this->SUCCESS;
        }
        $this->logger->logWarning(__FUNCTION__ . ": Unable to delete available course");
        return $this->FAILURE;
    }

    /**
     * Get all of the available courses.
     * 
     * @return $availableCourses - The array of arrays of available courses information.
     */
    public function getAvailableCourses() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Available_Courses;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $availableCourses = $query->fetchAll();
        $this->logger->logDebug(__FUNCTION__ . " " . print_r($availableCourses,1));
        return $availableCourses;
    }

    /**
     * Create a frequently asked quetion.
     * 
     * @param $adminUserId - The admin user id that created the FAQ.
     * @param $question - The question for the FAQ.
     * @param $answer - The answer that the admin would like to provide.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createFAQ($adminUserId, $question, $answer) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Frequently_Asked_Questions (admin_user_id,
                question, answer) VALUES (:adminUserId, :question, :answer);"
            );
            $query->bindParam(":adminUserId", $adminUserId);
            $query->bindParam(":question", $question);
            $query->bindParam(":answer", $answer);
            if ($query->execute()) {
                return $this->SUCCESS;
            }
            $this->logger->logWarning(__FUNCTION__ . ": Unable to create FAQ");
            return $this->FAILURE;

        } catch (Exception $e) {
            $this->logger->logWarning(__FUNCTION__ . " " . $e);
            return $this->FAILURE;
        }
    }

    /**
     * Delete a frequently asked question.
     * 
     * @param $faqId - The id of the FAQ to delete
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteFAQ($faqId) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "DELETE FROM Frequently_Asked_Questions WHERE faq_id = :faqId;"
            );
            $query->bindParam(":faqId", $faqId);
            if ($query->execute()) {
                return $this->SUCCESS;
            }
            $this->logger->logWarning(__FUNCTION__ . ": Unable to delete FAQ");
            return $this->FAILURE;

        } catch (Exception $e) {
            $this->logger->logWarning(__FUNCTION__ . " " . $e);
            return $this->FAILURE;
        }
    }

    /**
     * Update a frequently asked question.
     * 
     * @param $faqId - The ID of the FAQ to update.
     * @param $adminUserId - The user_id of the admin who is updating.
     * @param $question - The new question phrase.
     * @param $answer - The new answer phrase.
     * @return Returns TRUE if the update was successful, else FALSE.
     */
    public function updateFAQ($faqId, $adminUserId, $question, $answer) {
        try {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "UPDATE TABLE Frequently_Asked_Questions SET 
                 admin_user_id = :adminUserId,
                 question = :question, 
                 answer = :answer
                 WHERE faq_id = :faqId;"
            );
            $query->bindParam(":faqId", $faqId);
            $query->bindParam(":adminUserId", $adminUserId);
            $query->bindParam(":question", $question);
            $query->bindParam(":answer", $answer);
            if ($query->execute()) {
                return $this->SUCCESS;
            }
            $this->logger->logWarning(__FUNCTION__ . ": Unable to update FAQ");
            return $this->FAILURE;

        } catch (Exception $e) {
            $this->logger->logWarning(__FUNCTION__ . " " . $e);
            return $this->FAILURE;
        }
    }

    /**
     * Get all of the frequently asked questions.
     * 
     * @return $FAQs - The array of arrays of FAQs information.
     */
    public function getFAQs() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Frequently_Asked_Questions;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        if ($query->execute()) {
            $FAQs = $query->fetchAll();
            return $FAQs;
        }
        $this->logger->logWarning(__FUNCTION__ . ": Unable to get FAQs");
        return Array();
        
    }

    // public function login($username, $password){
    //     $salt = '!@%#^^%*&;rweltkjusofd;iajg168152410';
    //     $password=md5($password . $salt);
    //     $conn = $this->getConnection();
    //     $query = $conn->prepare("SELECT * FROM user where username = :username AND password = :password");
    //     $query->bindParam(':username', $username);
    //     $query->bindParam(':password', $password);
    //     $query->execute();
    //     $results=$query->fetch(PDO::FETCH_ASSOC);
    //     if (is_array($results) && 0 < count($results)){
    //         return true;
    //     } else {
    //         return false;
    //     }    
    // }
    
    // public function checkAccess($username) {
    //     $conn = $this->getConnection();
    //     $query = $conn->prepare("SELECT * FROM user where username = :username AND access = '1'");
    //     $query->bindParam(':username', $username);
    //     $query->execute();
    //     $results=$query->fetch(PDO::FETCH_ASSOC);
    //     if (is_array($results) && 0 < count($results)){
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
     
}
?>
