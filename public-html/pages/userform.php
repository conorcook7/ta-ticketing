<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    require_once '../components/header.php';
    require_once '../components/dao.php';
    $dao = new Dao();
    $page = 'userform.php';
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
        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Help Submission Form</h6>
                </div>
                <form method = "POST" action = "../handlers/user-form-handler.php">
                    <div class="card-body">
                        <select class="form-control"id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" name = 'courseID'>
                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownMenuButton">
                                <?php $courses = $dao->getAvailableCourses();
                                    foreach($courses as $course){ ?>
                                <option value = "<?php echo $course['available_course_id']?>"> <?php echo strtoupper(htmlentities($course['course_number'] . " - " . $course['course_name'])); ?> </option>
                                <?php } ?>
                            </div>
                        </select>
                    </div>
                    <div class = "card-body">
                        <label for="problem_description">Problem Description</label>
                        <textarea class="form-control" id="problem_description" rows="3" name = "description" maxlength="1000"></textarea>
                        <div class ="text-right p-1">
                            <span id="charNum">0</span>
                            <span>/</span>
                            <span id="maxLength">1000</span>
                        </div>
                        <br/>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <?php include_once '../components/footer.php' ?>
    <!-- End of Footer -->
</div>
<script src="../js/userform.js"></script>
<?php require_once '../components/scripts.php'; ?>