<?php

require_once 'KLogger.php';

class Dao {

  private $host = "us-cdbr-iron-east-05.cleardb.net";
  private $db = "heroku_c1e7d16168842d5";
  private $user = "b0c907fbbec6d1";
  private $pass = "d2566170";
  protected $logger;
  
  public function __construct () {
    $this->logger = new KLogger('/home/malikherring/CS401', KLogger::DEBUG);
  }
  
  public function getConnection () {
    try{
        $conn = 
            new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->pass);
        $this->logger->logDebug("Established a database connection.");
        return $conn;
    } catch (Exception $e) {
        echo "connection failed: " . $e->getMessage();
        $this->logger->logFatal("The database connection failed.");
    }
  }
  
  public function getUsers(){
    $conn = $this->getConnection();
    $query = $conn->prepare("select * from user");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $query->execute();
    $results = $query->fetchAll();
    $this->logger->logDebug(__FUNCTION__ . " " . print_r($results,1));
    return $results;
  }
  
  public function doesUserExist($email, $username){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT * FROM user where username = :username OR email = :email");
    $query->bindParam(':email', $email);
    $query->bindParam(':username', $username);
    $query->execute();
    $results=$query->fetch(PDO::FETCH_ASSOC);
    if (is_array($results) && 0 < count($results)){
        return true;
    } else {
        return false;
    }
  }
  
  public function login($username, $password){
    $salt = '!@%#^^%*&;rweltkjusofd;iajg168152410';
    $password=md5($password . $salt);
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT * FROM user where username = :username AND password = :password");
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();
    $results=$query->fetch(PDO::FETCH_ASSOC);
    if (is_array($results) && 0 < count($results)){
        return true;
    } else {
        return false;
    }    
  }
  
  public function increaseExp($username, $amount){
    $user=$this->getUser($username);
    $exp = ($user['exp'] + $amount);
    $accountID = $user['accountID'];
    $conn=$this->getConnection();
    $query = $conn->prepare("UPDATE user SET exp = :exp WHERE accountID = :accountID");
    $query->bindParam('exp', $exp );
    $query->bindParam('accountID', $accountID);
    $query->execute();
    $this->logger->logDebu(__FUNCTION__ . " username=[{$username}] exp=[{$exp}]");
  }
  
  public function getUser($username){
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $this->logger->logDebug(__FUNCTION__ . " " . print_r($results,1));
    return $results;
  }
  
  public function getToday($username){
    $user=$this->getUser($username);
    $accountID = $user['accountID'];
    $date = date("Y-m-d");
    $conn=$this->getConnection();
    $query = $conn->prepare("SELECT * FROM schedule WHERE date = :date AND completed = :completed AND accountID = :accountID");
    $query->bindParam('date', $date);
    $query->bindParam('completed', false);
    $query->bindParam('accountID', $accountID);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $this->logger->logDebug(__FUNCTION__ . " " . print_r($results, 1));
    return $results;
  }
  
  public function getTimePeriod($username, $beginDate, $endDate){
    $user=$this->getUser($username);
    $accountID = $user['accountID'];
    $conn=$this->getConnection();
    $query = $conn->prepare("SELECT * FROM schedule WHERE accountID = :accountID AND date BETWEEN :beginDate and :endDate");
    $query->bindParam('accountID', $accountID);
    $query->bindParam(':beginDate', $beginDate);
    $query->bindParam(':endDate', $endDate);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $this->logger->logDebug(__FUNCTION__ . " " . print_r($results, 1));
    return results;
  }
  
  public function saveUser($username, $email, $password){
    $salt = '!@%#^^%*&;rweltkjusofd;iajg168152410';
    $password=md5($password . $salt);
    $conn = $this->getConnection();
    $query = $conn->prepare("INSERT INTO user (username, email, password, exp, currentGoals, completeGoals) VALUES (:username, :email, :password, 0, 0, 0)");
    $query->bindParam(':username',$username);
    $query->bindParam(':email', $email);
    $query->bindParam(':password', $password);
    $this->logger->logDebug(__FUNCTION__ . " username=[{$username}] email=[{$email}]");
    $query->execute();
  }
  
  public function saveSchedule($title, $completionDate, $description, $username){
    $user=$this->getUser($username);
    $this->increaseExp($username, 5);
    $accountID=$user['accountID'];
    $currentGoals=$user['currentGoals'] + 1;
    $conn = $this->getConnection();
    $query = $conn->prepare("INSERT INTO schedule (title, completionDate, description, accountID, completed) VALUES (:title, :completionDate, :description, :accountID, :completed)");
    $query->bindParam(':title', $title);
    $query->bindParam(':completionDate', $completionDate);
    $query->bindParam(':description', $description);
    $query->bindParam(':accountID', $accountID);
    $query->bindParam(':completed', false);
    $this->logger->logDebug(__FUNCTION__ . " username=[{$username}] schedule title=[{$title}]");
    $query->execute();
    $query = $conn->prepare("UPDATE user SET currentGoals = :currentGoals WHERE accountID = :accountID");
    $query->bindParam(':currentGoals', $currentGoals);
    $query->bindParam(':accountID', $accountID);
    $this->logger->logDebug(__FUNCTION__ . " username=[{$username}] Current Goals = [{$currentGoals}]");
    $query->execute();
  }  
  
  public function checkAccess($username) {
    $conn = $this->getConnection();
    $query = $conn->prepare("SELECT * FROM user where username = :username AND access = '1'");
    $query->bindParam(':username', $username);
    $query->execute();
    $results=$query->fetch(PDO::FETCH_ASSOC);
    if (is_array($results) && 0 < count($results)){
        return true;
    } else {
        return false;
    }
  }
  
  public function verifyPassword($password){
    $regex='/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/';
    return preg_match($regex, $password);
  }
}

