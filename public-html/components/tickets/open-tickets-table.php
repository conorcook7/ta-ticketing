<?php $page = "open-tickets-table.php"; 
$my_ta_id = $_SESSION["user"]["user_id"];?>
<div class="container-fluid">
        <!-- All Open Tickets Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Open Tickets</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="open-tickets-table" width="100%" cellspacing="0">
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
          <!-- End of All open tickets -->
</div>