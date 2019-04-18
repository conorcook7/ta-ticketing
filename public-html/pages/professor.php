<?php
    require_once '../components/dao.php';
    require_once '../components/server-functions.php';
    $dao = new Dao();
    $page = 'professor.php';
    $nav = 'professor';
    
    // Setting the page for the navbar
    if(getPermission() == "PROFESSOR"){
      if(isset($_GET['page'])){
        $_SESSION['professor-selection'] = $_GET['page'];
        $selection = $_SESSION['professor-selection'];
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
          } else if ($selection == 'users-form'){
            $page = 'update-users.php';
          } else {
              header("Location: 404.php");
              exit();
          }
      } else {
        $_SESSION['professor-selection'] = 'DEFAULT';
      }
    } else {
      header("Location: 403.php");
      exit();
    }
    unset($_GET['page']);
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
            <?php if (isset($_SESSION["success"])){ ?>
            <div class="alert alert-success">
                <strong>Success!</strong> <?php echo $_SESSION["success"]; ?>
            </div>
            <?php } elseif (isset($_SESSION["failure"])) { ?>
            <div class="alert alert-danger">
                <strong>Failure!</strong> <?php echo $_SESSION["failure"]; ?>
            </div>
            <?php }
                unset($_SESSION["failure"]);
                unset($_SESSION["success"]);
                ?>
            <?php
                $selection = $_SESSION['professor-selection'];
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
                } else if ($selection == 'users-form'){
                  include_once '../components/users/update-users.php';
                }
                ?>
        </div>
        <?php require_once '../components/footer.php';?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<script src="../js/professor.js"></script>
<?php
    require_once '../components/logout-modal.php';
    require_once '../components/scripts.php';
    ?>