<?php 
  require_once '../components/header.php';
  require_once '../components/dao.php'; 
  $dao = new Dao("Dummy_TA_Ticketing")?>

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
        
        <?php include_once '../components/admin/users-table.php'?>
      </div>
    </div>
  </div>
<?php require_once '../components/footer.php';require_once '../components/scripts.php'; ?>

