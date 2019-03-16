<?php
// Require the logger
require_once 'KLogger.php';

// Require all of the dao traits
require_once 'dao-traits/dao-courses.php';
require_once 'dao-traits/dao-faq.php';
require_once 'dao-traits/dao-permissions.php';
require_once 'dao-traits/dao-ta.php';
require_once 'dao-traits/dao-tickets-closed.php';
require_once 'dao-traits/dao-tickets-open.php';
require_once 'dao-traits/dao-users.php';

/**
 * The data access object (Dao) for the website. This object uses a standard user for the local mysql instance.
 * The user is only created in the Dummy_TA_Ticketing database, it will have to be added manually to the production DB.
 */
class Dao {
  
    // Pass/Fail flags for methods
    private $SUCCESS = TRUE;
    private $FAILURE = FALSE;

    // MySQL generic user
    private $db = "Dummy_TA_Ticketing";
    private $user = "ta-ticketing";
    private $pass = "34$5iu98&7o7%76d4Ss35";

    // Local logger
    protected $logger;

    // Use all of the dao traits
    use DaoCourses;
    use DaoFaq;
    use DaoPermissions;
    use DaoTa;
    use DaoTicketsClosed;
    use DaoTicketsOpen;
    use DaoUsers;

    /**
     * Constructor for the Dao object.
     * 
     * @param $database - The database name to connect to.
     */
    public function __construct() {
        $this->logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
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
            $this->logger->logFatal(__FUNCTION__ . ": " . $e->getMessage());
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

    /**
     * Get all tickets.
     * 
     * @return $allTickets - The array of arrays of open tickets information.
     */
    public function getAllTickets() {
        $openTickets = $this->getOpenTickets();
        $max = sizeof($openTickets);
        for ($index = 0; $index <= $max; $index++) {
            $ticket[$index]['status'] = 'Open';
            $ticket[$index]['id'] = $ticket["open_ticket_id"];
        }
        $closedTickets = $this->getClosedTickets();
        $max = sizeof($closedTickets);
        for ($index = 0; $index <= $max; $index++) {
            $ticket[$index]['status'] = 'Closed';
            $ticket[$index]['id'] = $ticket["closed_ticket_id"];
        }
        return array_merge($openTickets, $closedTickets);
    }
}
?>
