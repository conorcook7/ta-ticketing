<?php
  require_once '../../components/dao.php';
  require_once '../../components/header.php';

  session_start();

  $page = 'available-courses.php';
  $nav = 'help';
?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Start of Sidebar -->
    <?php include_once '../../components/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Topbar -->
      <?php include_once '../../components/topbar.php'; ?>
      <!-- End of Topbar -->
      
      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid p-4">

          <!-- Available Courses heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Available Courses</h1>
          </div>

          <!-- Available Courses -->
          <?php
            $dao = new Dao("Dummy_TA_Ticketing");
            $courses = $dao->getAvailableCourses();
            foreach ($courses as $course) {
          ?>
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h1 class="h5 m-0 font-weight-bold text-primary"><?php echo strtoupper($course["course_name"]); ?></h1>
              </div>
              <div class="card-body">
                <p><?php echo $course["course_description"]; ?></p>
              </div>
            </div>
          <?php
            }
          ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include_once '../../components/footer.php'; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

<?php
  require_once "../../components/scripts.php";
?>