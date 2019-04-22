<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    $page = "my-ta-tickets.php";
    $my_ta_id = $_SESSION["user"]["user_id"];
    $my_course_id = $dao->getMyCourseID($my_ta_id);
    $myTickets = $dao->getMyOpenTickets($my_course_id['0']['available_course_id']);
?>
<div id="toggle-close-ticket" class="p-4 mb-4" style="display: none">
    <form method="POST" id="close-ticket-form" action="../handlers/ticket-handler.php">
        <input id="open-ticket-id" type="hidden" name="open_ticket_id" value="" />
        <input id="closer-user-id" type="hidden" name="closer_user_id" value="" />
        <label for="closing_description">Ticket Closing Description</label>
        <textarea
            class="form-control py-2 w-50"
            id="closing-description"
            name="closing_description"
            rows=4
            maxlength=500
            required="true"
            placeholder="Please describe how you helped with this ticket..."></textarea>
        <div class="text-right w-50">
            <span id="char-count">0</span>
            <span>/</span>
            <span id="max-char-count">500</span>
        </div>
        <div class="d-flex justify-content-start w-50">
            <button type="submit" class="btn btn-primary mr-2">Finish Closing</button>
            <button type="button" class="btn btn-danger hide-form">Cancel</button>
        </div>
    </form>
</div>
<div class="container-fluid">
    <!-- Start of My Tickets Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Open Tickets</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data_table" id="ta-open-tickets-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="center">Queue</th>
                            <th class="center">Student Name</th>
                            <th class="center">Node</th>
                            <th class="center">Course</th>
                            <th class="center">Ticket Description</th>
                            <th class="center">Status</th>
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