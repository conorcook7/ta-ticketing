<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    $page = "tickets-table.php";
?>
<div class="container-fluid">
    <!-- All Tickets Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Tickets</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data_table" id="all-tickets-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Student Name</th>
                            <th class="center nodeInfo">Node Number</th>
                            <th class="center description">Course</th>
                            <th class="center">Status</th>
                            <th class="center action">Description</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="bug-report-link" class="text-right pt-4 m-0">
                <a href="<?php echo generateUrl('/pages/help/bug-report.php'); ?>">Having issues?</a>
            </div>
        </div>
    </div>
    <!-- End of all tickets. -->
</div>