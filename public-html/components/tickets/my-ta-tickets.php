<?php $page = "my-ta-tickets.php";
$my_ta_id = $_SESSION["user"]["user_id"];
$my_course_id = $dao->getMyCourseID($my_ta_id);
$myTickets = $dao->getMyOpenTickets($my_course_id['0']['available_course_id']);
 ?>
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
            </div>
          </div>
</div>