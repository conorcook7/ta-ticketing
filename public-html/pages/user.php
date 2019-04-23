<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
    // Setting for the navbar
    $nav = 'user';
    $page = 'user.php';
    
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
            <?php
                require_once '../components/topbar.php';
                require_once "../components/success-failure-alert.php";
            ?>
            <!-- End of Topbar -->
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
                            <table class="table table-bordered data_table" id="available-tas-table" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="center">TA Name</th>
                                        <th class="center description">TA Email</th>
                                        <th class="center">TA Course</th>
                                    </tr>
                                </thead>
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