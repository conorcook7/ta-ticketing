<?php
    require_once '../components/header.php';
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
          } else if ($selection == 'users-form'){
            $page = 'update-users.php';
          } else if ($selection == 'faq'){
            $page = 'faq.php';
          } else if ($selection == 'bug-reports') {
            $page = 'bug-reports.php';
          } else if ($selection == 'blacklist') {
            $page = 'blacklist.php';
          }
      } else {
        $_SESSION['admin-selection'] = 'DEFAULT';
      }
    } else {
      $_SESSION['admin-selection'] = 'UNNAUTHORIZED';
    }
    unset($_GET['id']);
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
                $selection = $_SESSION['admin-selection'];
                if ($selection == 'UNNAUTHORIZED'){ ?>
            <div class="d-flex flex-column justify-content-center text-center p-4 h-100">
                <div class="error mx-auto" data-text="403">403</div>
                <p class="lead text-gray-800 mb-5">Permission Denied</p>
                <a href="<?php echo generateUrl('/pages/') . strtolower($_SESSION['user']['permission']) . '.php'; ?>">&larr; Back to Dashboard</a>
            </div>
            <?php
                } elseif ($selection == 'DEFAULT' || $selection == 'users'){
                  include_once '../components/users/users-table.php';
                } elseif ($selection == 'online-users'){
                  include_once '../components/users/online-users-table.php';
                } elseif ($selection == 'tickets'){
                  include_once '../components/tickets/tickets-table.php';
                } elseif ($selection == 'open-tickets'){
                  include_once '../components/tickets/open-tickets-table.php';
                } elseif ($selection == 'closed-tickets'){
                  include_once '../components/tickets/closed-tickets-table.php';
                } elseif ($selection == 'classes'){
                  include_once '../components/users/classes.php';
                } elseif ($selection == 'users-form'){
                  include_once '../components/users/update-users.php';
                } elseif ($selection == 'faq'){
                  include_once '../components/users/faq.php';
                } elseif ($selection == 'bug-reports') {
                  include_once '../components/users/bug-reports.php';
                } elseif ($selection == 'blacklist') {
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