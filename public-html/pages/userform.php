<?php
  require_once '../components/header.php';
  require_once '../components/dao.php';
  $dao = new Dao("Dummy_TA_Ticketing")
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

        <button id="dropdownMenuButton" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Course Name
        </button>
      </div>
    </div>
 </div>
<?php require_once '../components/footer.php';require_once '../components/scripts.php'; ?>
