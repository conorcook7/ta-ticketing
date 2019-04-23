<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    session_start();
    require_once "../components/dao.php";
    require_once "../components/server-functions.php";
    $nav = 'ta';
    $page = 'ta.php';
    $permission = getPermission();
      if($permission == "TA" || $permission == "PROFESSOR" || $permission == "ADMIN"){
        if(isset($_GET['page'])){
          $_SESSION['ta-selection'] = $_GET['page'];
          $selection = $_SESSION['ta-selection'];
            if ($selection == 'DEFAULT' || $selection == 'ta'){
                $page = 'ta.php';
            } else if ($selection == 'my-tickets'){
                $page = 'my-ta-tickets.php';
            } else if ($selection == 'all-tickets'){
                $page = 'tickets-table.php';
            } else if ($selection == 'open-tickets'){
              $page = 'open-tickets-table.php';
            } else if ($selection == 'closed-tickets'){
              $page = 'closed-tickets-table.php';
            } else if ($selection == 'create-ticket'){
              header('Location: userform.php');
              exit();
            } else {
              header("Location: 404.php");
              exit();
            }
        } else {
          $_SESSION['ta-selection'] = 'DEFAULT';
        }
      } else {
        header("Location: 403.php");
        exit();
      }
    
      require_once "../components/header.php";
    
      try{
        $dao = new Dao();
        $users = $dao->getUsers();
    
      }catch(Exception $e) {
        $logger = getServerLogger();
        $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
        exit(0);
      }
    ?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php';?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="">

            <!-- Topbar -->
            <?php
                require_once '../components/topbar.php';
                // Include the success/failure alert
                require_once "../components/success-failure-alert.php";
            ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <?php
                    $selection = $_SESSION['ta-selection'];
                    
                    if ($selection == 'DEFAULT' || $selection == 'ta' || $selection == 'my-tickets'){
                      include_once '../components/tickets/my-ta-tickets.php';
                    } elseif ($selection == 'all-tickets'){
                      include_once '../components/tickets/tickets-table.php';
                    } elseif ($selection == 'open-tickets'){
                      include_once '../components/tickets/open-tickets-table.php';
                    } elseif ($selection == 'closed-tickets'){
                      include_once '../components/tickets/closed-tickets-table.php';
                    }
                    ?>
            </div>
            <!-- End Page Content -->
        </div>
        <!-- End of Main Content -->
        <?php include_once '../components/footer.php' ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<!-- Scripts -->
<?php 
    require_once '../components/logout-modal.php';
    require_once '../components/scripts.php' 
?>