<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once '../components/dao.php';
    require_once '../components/header.php';
    
    session_start();
    
    $page = 'teaching-assistants.php';
    $nav = 'teaching-assistants';
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
                    <span class="h3 mb-0 text-gray-800">Teaching Assistants</span>
                    <div class="text-right my-1">
                        <input id="ta-search" class="form-control text-gray-800" type="textarea" style="background: inherit" placeholder="Search..." maxlength=1024/>
                    </div>
                </div>
                <!-- Available Courses -->
                <?php
                    $dao = new Dao();
                    $tas = $dao->getTeachingAssistants(10);
                    foreach ($tas as $ta) {
                        $startTime = new DateTime($ta["start_time_past_midnight"]);
                        $endTime = new DateTime($ta["end_time_past_midnight"]);
                        $createDate = new DateTime($ta["create_date"]);
                ?>
                <div class="card shadow mb-4 ta">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between mr-4">
                            <span class="h4 m-0 font-weight-bold text-primary"><?php echo htmlentities($ta["first_name"] . " " . $ta["last_name"]); ?></span>
                            <span class="h4 m-0 font-weight-bold text-primary"><?php echo htmlentities($ta["course_number"]); ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="h5 text-gray-800">
                            <span class="text-gray-600">Contact: </span><?php echo htmlentities($ta["email"]); ?>
                        </div>
                        <div class="h5 text-gray-800">
                            <span class="text-gray-600">Usual Schedule: </span>
                            <?php echo $startTime->format("g:i A") . " - " . $endTime->format("g:i A"); ?>
                        </div>
                        <div class="h5 text-gray-800">
                            <span class="text-gray-600">Course: </span><?php echo htmlentities($ta["course_name"]); ?>
                            <p class="my-4 mx-4"><?php echo htmlentities($ta["course_description"]); ?></p>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-gray-800">
                            <p class="text-right text-gray-600">TA Since: <?php echo $createDate->format("F jS Y"); ?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
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
<script src="../js/ajax/teaching-assistants.js"></script>
<?php
    require_once "../components/scripts.php";
?>