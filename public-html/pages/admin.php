<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once '../components/dao.php';
    require_once '../components/server-functions.php';
    $dao = new Dao();
    $page = 'admin.php';
    $nav = 'admin';
    
    // Setting the page for the navbar
    if(getPermission() == "ADMIN"){
      if(isset($_GET['id'])){
        $_SESSION['admin-selection'] = $_GET['id'];
        $selection = $_SESSION['admin-selection'];
          if ($selection == 'DEFAULT' || $selection == 'users'){
              $page = 'users-table.php';
          } else if ($selection == 'online-users'){
              $page = 'online-users-table.php';
          } else if ($selection == 'tickets'){
              $page = 'tickets-table.php';
          } else if ($selection == 'open-tickets'){
            $page = 'open-tickets-table.php';
          } else if ($selection == 'closed-tickets'){
            $page = 'closed-tickets-table.php';
          } else if ($selection == 'classes'){
            $page = 'classes.php';
          } else if ($selection == 'faq'){
            $page = 'faq.php';
          } else if ($selection == 'bug-reports') {
            $page = 'bug-reports-table.php';
          } else if ($selection == 'blacklist') {
            $page = 'blacklist.php';
          } else {
              header("Location: 404.php");
              exit();
          }
      } else {
        $_SESSION['admin-selection'] = 'DEFAULT';
      }
    } else {
        header("Location: 403.php");
        exit();
    }
    unset($_GET['id']);
    require_once '../components/header.php';
    ?>
<div id="wrapper">
    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php'; ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <?php include_once '../components/topbar.php'; ?>
            <!-- End of Topbar -->
            <?php
                // Add the alert message
                require_once "../components/success-failure-alert.php";

                // Include the correct page
                $selection = $_SESSION['admin-selection'];
                if ($selection == 'DEFAULT' || $selection == 'users'){
                  include_once '../components/users/users-table.php';
                } else if ($selection == 'online-users'){
                  include_once '../components/users/online-users-table.php';
                } else if ($selection == 'tickets'){
                  include_once '../components/tickets/tickets-table.php';
                } else if ($selection == 'open-tickets'){
                  include_once '../components/tickets/open-tickets-table.php';
                } else if ($selection == 'closed-tickets'){
                  include_once '../components/tickets/closed-tickets-table.php';
                } else if ($selection == 'classes'){
                  include_once '../components/users/classes.php';
                } else if ($selection == 'faq'){
                  include_once '../components/users/faq.php';
                } else if ($selection == 'bug-reports') {
                  include_once '../components/users/bug-reports-table.php';
                } else if ($selection == 'blacklist') {
                  include_once '../components/users/blacklist.php';
                }
            ?>
        </div>
        <?php require_once '../components/footer.php';?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<script src="../js/admin.js"></script>
<?php
    require_once '../components/logout-modal.php';
    require_once '../components/scripts.php';
    ?>