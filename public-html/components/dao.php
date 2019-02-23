<?php

//require_once 'KLogger.php';

/**
 * The data access object (Dao) for the website. This object uses a standard user for the local mysql instance.
 * The user is only created in the Dummy_TA_Ticketing database, it will have to be added manually to the production DB.
 */
class Dao {
  
    private const SUCCESS = TRUE;
    private const FAILURE = FALSE;

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
        //$this->logger = new KLogger('../../ta-ticketing.log', KLogger::DEBUG);
        $this->db = $database;
    }
  
    /**
     * Attempts to connect to the local MySQL instance with the user ta-ticketing.
     * 
     * @return $conn - The connection to the localhost MySQL database.
     */
    public function getConnection() {
        try{
            $conn = new PDO("mysql:host=127.0.0.1;dbname={$this->db}", $this->user, $this->pass);
            //$this->logger->logDebug("Established a database connection.");
            return $conn;
        } catch (Exception $e) {
            echo "connection failed: " . $e->getMessage();
            //$this->logger->logFatal("The database connection failed.");
            return $this->$FAILURE;
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
            return TRUE;
        } else {
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
        if ($email != NULL) {
            $query = $conn->prepare("SELECT * FROM Users WHERE email = :email;");
            $query->bindParam(":email", $email);
        } else if ($userId != NULL) {
            $query = $conn->prepare("SELECT * FROM Users WHERE user_id = :userId;");
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
     * @param $password - The raw password of the user to create.
     * @param $firstName - The first name of the user if given, else NULL.
     * @param $lastName - The last name of the user if given, else NULL.
     * @return Returns TRUE if the user was created, else FALSE
     */
    public function createUser($email, $password, $firstName=NULL, $lastName=NULL) {
        $exists = $this->userExists($email);
        if (!$exists && $this->verifyPassword($password)) {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Users (permission_id, email, password, first_name, last_name) " .
                "VALUES (1, :email, :hashedPassword, :firstName, :lastName);"
            );
            $query->bindParam(":email", $email);
            $query->bindParam(":hashedPassword", $this->hashPassword($password));
            $query->bindParam(":firstName", $firstName);
            $query->bindParam(":lastName", $lastName);
            $status = $query->execute();
            if (status) {
                return $this->$SUCCESS;
            }
        }
        return $this->$FAILURE;
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
                return $this->$SUCCESS;
            }
        }
        return $this->$FAILURE;
    }

    /**
     * Returns all of the users.
     * @return $users - All of the users from the Users table.
     */
    public function getUsers(){
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Users;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $users = $query->fetchAll();
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($users,1));
        return $users;
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
            "SELECT * FROM Teaching_Assistants JOIN Users
             ON Teaching_Assistants.user_id = Users.user_id;"
        );
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $teachingAssistants = $query->fetchAll();
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($teachingAssistants,1));
        return $teachingAssistants;
    }

    /**
     * Create a new teaching assistant based on an existing user.
     * 
     * @param $userId - The user id of the student to add to the TAs.
     * @param $startTime - The start time past midnight for the TA to work.
     * @param $endTime - The end time past midnight for the TA to stop work.
     * @return Returns TRUE if the creation was successful, else FALSE.
     */
    public function createTeachingAssistant($userId, $startTime, $endTime) {
        $conn = $this->getConnection();
        $query = $conn->prepare(
            "INSERT INTO Teaching_Assistants (user_id,
             start_time_past_midnight, end_time_past_midnight) VALUES (
             :userId, :startTime, :endTime)"
        );
        $query->bindParam(":userId", $userId);
        $query->bindParam(":startTime", $startTime);
        $query->bindParam(":endTime", $endTime);
        if ($query->execute()) {
            $query = $conn->prepare(
                "UPDATE TABLE Users SET permission_id = 2 
                 WHERE user_id = :userId"
            );
            $query->bindParam(":userId", $userId);
            if ($query->execute()) {
                return $this->$SUCCESS;
            } else {
                return $this->$FAILURE;
            }
        } else {
            return $this->$FAILURE;
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
                return $this->$SUCCESS;
            } else {
                return $this->$FAILURE;
            }
        } else {
            return $this->$FAILURE;
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
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($permissionLevels,1));
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
            return $this->$SUCCESS;
        } else {
            return $this->$FAILURE;
        }
    }

    public function deletePermissionsLevel() { }

    /**
     * Get all of the open tickes.
     * @return $openTickets - The array of arrays of open tickets information.
     */
    public function getOpenTickets() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Open_Tickets;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $openTickets = $query->fetchAll();
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($openTickets,1));
        return $openTickets;
    }

    public function createTicket() { }

    public function deleteTicket() { }

    public function closeTicket() { }
    
    /**
     * Get all of the closed tickes.
     * @return $closedTickets - The array of arrays of closed tickets information.
     */
    public function getClosedTickets() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Closed_Tickets;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $closedTickets = $query->fetchAll();
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($closedTickets,1));
        return $closedTickets;
    }

    public function openClosedTicket() { }

    /**
     * Get the available course by name, number, or id.
     * @param $courseId - The course id to search for.
     * @param $courseNumber - The course number to search for.
     * @param $courseName - The course name to search for.
     * @return $availableCourse - The array of course information, else and empty array.
     */
    public function getAvailableCourse($courseId=NULL, $courseNumber=NULL, $courseName=NULL) {
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
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($availableCourses,1));
        return $availableCourse;
    }

    public function createAvailableCourse($courseNumber, $courseName=NULL, $courseSection=NULL) {
        $exists = $this->userExists($email);
        if (!$exists && $this->verifyPassword($password)) {
            $conn = $this->getConnection();
            $query = $conn->prepare(
                "INSERT INTO Users (permission_id, email, password, first_name, last_name) " .
                "VALUES (1, :email, :hashedPassword, :firstName, :lastName);"
            );
            $query->bindParam(":email", $email);
            $query->bindParam(":hashedPassword", $this->hashPassword($password));
            $query->bindParam(":firstName", $firstName);
            $query->bindParam(":lastName", $lastName);
            $status = $query->execute();
            if (status) {
                return $this->$SUCCESS;
            }
        }
        return $this->$FAILURE;
    }

    /**
     * Attempts to delete a course from the database.
     * @param $courseId - The course_id corresponding to the row to delete.
     * @return Returns TRUE if the deletion was successful, else FALSE.
     */
    public function deleteAvailableCourse($courseId) {
        $conn = $this->getConnection();
        $query = $conn->prepare("DELETE FROM Available_Courses WHERE course_id = :courseId;");
        $query->bindParam(":courseId", $courseId);
        $status = $query->execute();
        if (status) {
            return $this->$SUCCESS;
        }
        return $this->$FAILURE;
    }

    /**
     * Get all of the available courses.
     * @return $availableCourses - The array of arrays of available courses information.
     */
    public function getAvailableCourses() {
        $conn = $this->getConnection();
        $query = $conn->prepare("SELECT * FROM Available_Courses;");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute();
        $availableCourses = $query->fetchAll();
        //$this->logger->logDebug(__FUNCTION__ . " " . print_r($availableCourses,1));
        return $availableCourses;
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
