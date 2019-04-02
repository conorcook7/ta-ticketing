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
  <div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
    <div class="d-sm-flex align-items-center justify-content-between">
      <h6 class="m-0 font-weight-bold text-primary">My Open Tickets</h6>
      <form action = "userform.php">
        <button type="submit" class="d-none d-sm-inline-block btn btn-success"><i class="fas fa-plus-square fa-xl text-white pr-2"></i>Create New Ticket</button>
      </form>
    </div>
  </div>
    <div class="card-body">
      <div class="table-responsive">
		    <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
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
		  <tbody>
			<?php
				$openTickets = $dao->getOpenTickets();
				for ($i = 0; $i < sizeof($openTickets); $i++) {
          if ($openTickets[$i]["creator_user_id"] == $_SESSION["user"]["user_id"]) {
      ?>
				<tr>
          <form method="POST" action="../handlers/user-open-ticket-handler.php">
            <input type="hidden" name="open_ticket_id" value="<?php echo $openTickets[$i]['open_ticket_id']; ?>"/>
            <td class="center"><?php echo ($i + 1); ?></td>
            <td class="center"><?php echo htmlentities($openTickets[$i]["node_number"]); ?></td>
            <td class="center"><?php echo strtoupper(htmlentities($openTickets[$i]["course_name"])); ?></td>
            <td class="center"><?php
              $updateDate = new DateTime($openTickets[$i]["update_date"]);
              echo $updateDate->format("F jS Y \a\\t g:i A");
            ?></td>
            <td class="center">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="<?php echo "#my-ticket-" . $i;?>">
                  More Info
              </button>

              <!-- Modal -->
              <div class="modal fade" id="<?php echo "my-ticket-" . $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                          <div class="modal-body"><?php echo htmlentities($openTickets[$i]['description']); ?></div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <th class="center">
              <button type="submit" class="btn btn-block btn-danger">
                <i class="fas fa-times fa-xl text-white pr-2"></i>
                Cancel Ticket
              </button>
            </th>
          </form>
				</tr>
      <?php
          }
        }
      ?>
		  </tbody>
		</table><br />
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
		    <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
          <thead>
          <tr>
            <th class="center">Ticket #</th>
            <th class="center">Ticket Creator</th>
            <th class="center">Ticket Closer</th>
            <th class="center">Course Name</th>
            <th class="center">Date Solved</th>
            <th class="center description">Ticket Description</th>
            <th class="center">Action</th>
          </tr>
		  </thead>
		  <tbody>
			<?php
        $closedTickets = $dao->getClosedTickets();
				for ($i = 0; $i < sizeof($closedTickets); $i++) {
          if ($closedTickets[$i]["student_user_id"] == $_SESSION["user"]["user_id"]) {
      ?>
				<tr>
          <form method="POST" action="../handlers/user-closed-ticket-handler.php">
            <input type="hidden" name="closed_ticket_id" value="<?php echo $closedTickets[$i]['closed_ticket_id']; ?>"/>
            <td class="center"><?php echo $closedTickets[$i]["closed_ticket_id"]; ?></td>
            <td class="center"><?php echo htmlentities($closedTickets[$i]["student_first_name"] . " " . $closedTickets[$i]["student_last_name"]); ?></td>
            <td class="center"><?php echo htmlentities($closedTickets[$i]["ta_first_name"] . " " . $closedTickets[$i]["ta_last_name"]); ?></td>
            <td class="center"><?php echo strtoupper(htmlentities($closedTickets[$i]["course_name"])); ?></td>
            <td class="center"><?php
              $updateDate = new DateTime($closedTickets[$i]["update_date"]);
              echo $updateDate->format("F jS Y \a\\t g:i A");
            ?></td>
            <td class="center">
              <!-- Button trigger modal -->
              <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="<?php echo "#my-closed-ticket-" . $i;?>">
                  More Info
              </button>

              <!-- Modal -->
              <div class="modal fade" id="<?php echo "my-closed-ticket-" . $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                          <div class="modal-body"><?php echo htmlentities($closedTickets[$i]['description']); ?></div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <th class="center">
              <button type="submit" class="btn btn-block btn-success">
                <i class="fas fa-redo fa-xl text-white pr-2"></i>
                Reopen Ticket
              </button>
            </th>
          </form>
				</tr>
      <?php
          }
        }
      ?>
		  </tbody>
		</table><br />
  </div>
  </div>
  </div>
</div>
<!-- End My Closed Tickets -->

<div class="container-fluid">
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Teaching Assistants</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
        <thead>
        <tr>
          <th class="center">TA Name</th>
          <th class="center description">TA Email</th>
          <th class="center">TA TimeSlot</th>
        </tr>
    </thead>
		<tbody>
			<?php
				$tas = $dao->getAvailableTeachingAssistants();
				foreach($tas as $ta) {
          $startTime = new DateTime($ta["start_time_past_midnight"]);
          $endTime = new DateTime($ta["end_time_past_midnight"]);
      ?>
				<tr>
					<td class="center"><?php echo htmlentities($ta['first_name']) . " " . htmlentities($ta['last_name']); ?></td>
					<td class="center"><?php echo htmlentities($ta['email']); ?></td>
          <td class="center"><?php echo $startTime->format("g:i A") . " - " . $endTime->format("g:i A"); ?></td>
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
