<?php
session_start();
require_once '../components/dao.php';
require_once '../components/server-functions.php';

$dao = new Dao('Dummy_TA_Ticketing');
//echo "<pre>"; print_r($_POST) ;  echo "</pre>";
$user_id = 0;
$course_id = 0;
if(isset($_SESSION['user']['email'])){
  $user = $dao->getUser($_SESSION['user']['email']);
  $user_id = $user['user_id'];
}
if(isset($_POST['courseName'])){
  $course = $dao->getAvailableCourse($_POST['courseName']);
  echo "<pre>" . print_r($course, 1) . "</pre>";
  $course_id = $course['available_course_id'];
}
$nodeNum = getNodeNumber();
echo $course_id;
echo $_POST['description'];
echo $_POST['courseName'];
if(isset($_POST['courseName']) && isset($_POST['description']) && $user_id != 0 && $course_id != 0){
    echo print_r($_POST, 1);
    $descript = $_POST['description'];
    $newTicket = $dao->createTicket($course_id,$user_id,$nodeNum, $description = $descript);
    echo "\n" . $newTicket;
}
echo "<pre>" . $newTicket . "</pre>";
if($newTicket){
  header("Location: ../pages/user.php");
  exit;
}
?>
