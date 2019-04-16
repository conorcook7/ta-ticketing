<?php
    // Setting for the navbar
    $nav = 'user';
    $page = 'user.php';
    
    require_once '../components/header.php';
    require_once '../components/dao.php';
    $dao = new Dao();
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
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">My Open Tickets</h6>
                            <form action = "userform.php">
                                <button type="submit" class="d-none d-sm-inline-block btn btn-success">
                                    <i class="fas fa-plus-square fa-xl text-white pr-2"></i>Create New Ticket
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered data_table" id="user-open-tickets-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="center">Queue #</th>
                                        <th class="center">Node</th>
                                        <th class="center">Course Name</th>
                                        <th class="center">Queue Time</th>
                                        <th class="center description">Ticket Description</th>
                                        <th class="center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div id="bug-report-link" class="text-right pt-4 m-0">
                            <a href="<?php echo generateUrl('/pages/help/bug-report.php'); ?>">Having issues?</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- My Closed Tickets -->
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">My Closed Tickets</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered data_table" id="user-closed-tickets-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="center">Ticket #</th>
                                        <th class="center">Ticket Creator</th>
                                        <th class="center">Ticket Closer</th>
                                        <th class="center">Course Name</th>
                                        <th class="center">Date Solved</th>
                                        <th class="center description">Ticket Description</th>
                                        <th class="center description">Closing Description</th>
                                        <th class="center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End My Closed Tickets -->
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Available Teaching Assistants</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered data_table generic-data-table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="center">TA Name</th>
                                        <th class="center description">TA Email</th>
                                        <th class="center">TA TimeSlot</th>
                                        <th class="center">TA Course</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $tas = $dao->getAvailableTeachingAssistants();
                                        foreach($tas as $ta) {
                                              $startTime = new DateTime($ta["start_time_past_midnight"]);
                                              $endTime = new DateTime($ta["end_time_past_midnight"]);
                                              $course = $dao->getAvailableCourseById($ta['available_course_id']);
                                          ?>
                                    <tr>
                                        <td class="center"><?php echo htmlentities($ta['first_name']) . " " . htmlentities($ta['last_name']); ?></td>
                                        <td class="center"><?php echo htmlentities($ta['email']); ?></td>
                                        <td class="center"><?php echo $startTime->format("g:i A") . " - " . $endTime->format("g:i A"); ?></td>
                                        <td class="center"><?php echo htmlentities($course['course_name']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once '../components/footer.php'?>
    </div>
</div>
</div>
<?php require_once '../components/scripts.php'; ?>