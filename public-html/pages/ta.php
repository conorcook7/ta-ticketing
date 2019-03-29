<?php

// Settings for the navbar
$nav = 'ta';
$page = 'ta.php';

require_once '../components/dao.php';
  try{
      $dao = new Dao('Dummy_TA_Ticketing');
      $users = $dao->getUsers();

      $my_ta_id = $_SESSION[user][user_id]; //need a function for this ID for the TA assistant
      // $my_ta_id =
      $my_course_id = 1; //need a function for this ID for the courses table
      // $my_course_id =



      // $allOpenTickets = $dao->getOpenTickets();
      // $myTickets = $dao->getMyOpenTickets($my_course_id);
      // $closedTickets = $dao->getClosedTickets();
      // $availableTAs = $dao->getAvailableTeachingAssistants();
      // $availableCourses = $dao->getAvailableCourses();

  }catch(Exception $e) {
    echo 'Unable to get DAO information: ',  $e->getMessage(), "\n";
    exit(0);
  }
require_once '../components/header.php';
?>

  <!-- Page Wrapper -->
  <div id="wrapper">


    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php';?>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include_once '../components/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- MY Open Tickets Table -->
          <?php include_once '../components/tickets/my-ta-tickets.php' ?>
          <!-- End of MY open tickets -->

          <!-- All Open Tickets Table -->
          <?php include_once '../components/tickets/open-tickets-table.php' ?>
          <!-- End of All open tickets -->

          <!-- All Closed Tickets Table -->
          <?php include_once '../components/tickets/closed-tickets-table.php' ?>
          <!-- End of Closed tickets. -->

        </div>
        <!-- End of container-fluid -->

      </div>
      <!-- End of Main Content -->

     <!-- Footer -->
     <?php include_once '../components/footer.php' ?>
     <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

<!-- Scripts -->
<?php 
  require_once '../components/logout-modal.php';
  require_once '../components/scripts.php' 
?>
<!-- End of Scripts -->

