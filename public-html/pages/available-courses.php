<?php
    require_once '../components/dao.php';
    require_once '../components/header.php';
    
    session_start();
    
    $page = 'available-courses.php';
    $nav = 'courses';
?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Topbar -->
        <?php include_once '../components/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid p-4">

                <!-- Available Courses heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
                    <span class="h3 mb-0 text-gray-800">Available Courses</span>
                    <div class="text-right my-1">
                        <input id="ac-search" class="form-control text-gray-800" type="textarea" style="background: inherit" placeholder="Search..." maxlength=1024/>
                    </div>
                </div>
                <!-- Available Courses -->
                <?php
                    $dao = new Dao();
                    $courses = $dao->getAvailableCourses(10);
                    foreach ($courses as $course) {
                    ?>
                <div class="card shadow mb-4 ac">
                    <div class="card-header py-3">
                        <span class="h5 m-0 font-weight-bold text-primary">
                            <?php echo strtoupper(htmlentities($course["course_number"] . " - " . $course["course_name"])); ?>
                        </span>
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
        <?php include_once '../components/footer.php'; ?>
        <!-- End of Footer -->
        
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<script src="../js/ajax/available-courses.js"></script>
<?php
    require_once "../components/scripts.php";
?>