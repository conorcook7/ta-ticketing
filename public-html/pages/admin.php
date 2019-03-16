<?php
  require_once '../components/header.php';
  require_once '../components/dao.php'; 
  $dao = new Dao();
  $page = 'admin.php';
  $nav = 'admin';
  
  if($_SESSION['user']['access-level'] <= 3){
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
        }
    } else {
      $_SESSION['admin-selection'] = 'DEFAULT';
    }
  } else {
    $_SESSION['admin-selection'] = 'UNNAUTHORIZED';
  }
  
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
        $selection = $_SESSION['admin-selection'];
        if ($selection == 'UNNAUTHORIZED'){ ?>
          <!-- 404 Error Text -->
          <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
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
        }
        ?>
      </div>
    </div>
  </div>
<?php
  require_once '../components/footer.php';
  require_once '../components/logout-modal.php';
  require_once '../components/scripts.php';
 ?>

