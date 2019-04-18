<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    $page = "closed-tickets-table.php";
?>
<div class="container-fluid">
    <!-- All Closed Tickets Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Closed Tickets</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data_table" id="closed-tickets-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="center">Student Name</th>
                            <th class="center">Teaching Assistant</th>
                            <th class="center nodeInfo">Course</th>
                            <th class="center description">Ticket Description</th>
                            <th class="center">Closing Remarks</th>
                            <th class="center action">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div id="bug-report-link" class="text-right pt-4 m-0">
                <a href="<?php echo generateUrl('/pages/help/bug-report.php'); ?>">Having issues?</a>
            </div>
        </div>
    </div>
    <!-- End of Closed tickets. -->
</div>