<?php

// Settings for the navbar
$nav = 'ta';
$page = 'ta.php';
require_once '../components/header.php';
// require_once '../components/dao.php';
  try{
      $dao = new Dao();
      $users = $dao->getUsers();

  }catch(Exception $e) {
    echo 'Unable to get DAO information: ',  $e->getMessage(), "\n";
    exit(0);
  }
  // if($_SESSION['user']['access_level'] == 2){
  //   if(isset($_GET['page'])){
  //     $_SESSION['ta-selection'] = $_GET['page'];
  //     $selection = $_SESSION['ta-selection'];
  //       if ($selection == 'DEFAULT' || $selection == 'users'){
  //           $page = 'users-table.php';
  //       } else if ($selection == 'my-tickets'){
  //           $page = 'my-ta-tickets.php';
  //       } else if ($selection == 'tickets'){
  //           $page = 'tickets-table.php';
  //       } else if ($selection == 'open-tickets'){
  //         $page = 'open-tickets-table.php';
  //       } else if ($selection == 'closed-tickets'){
  //         $page = 'closed-tickets-table.php';
  //       } else if ($selection == 'classes'){
  //         $page = 'classes.php';
  //       } else if ($selection == 'users-form'){
  //         $page = 'update-users.php';
  //       } else if ($selection == 'faq'){
  //         $page = 'faq.php';
  //       }
  //   } else {
  //     $_SESSION['ta-selection'] = 'DEFAULT';
  //   }
  // } else {
  //   $_SESSION['ta-selection'] = 'UNNAUTHORIZED';
  // }
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
        <!-- Footer -->
        <?php include_once '../components/footer.php' ?>
        <!-- End of Footer -->
      </div>
      <!-- End of Main Content -->

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

