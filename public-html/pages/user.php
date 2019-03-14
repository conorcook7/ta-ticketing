<?php
  require_once '../components/header.php';
  require_once '../components/dao.php';
  $dao = new Dao("Dummy_TA_Ticketing")?>

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
      <h6 class="h3 mb-0 text-gray-800">My Open Tickets</h6>
      <form action = "userform.php">
        <button type="submit" class="d-none d-sm-inline-block btn btn-success"><i class="fas fa-plus-square fa-xl text-white pr-2"></i>Create New Ticket</button>
      </form>
    </div>
  </div>
    <div class="card-body">
      <div class="table-responsive">
		    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
          <tr>
            <th class="center">Queue #</th>
            <th class="center">Node</th>
            <th class="center">Course Name</th>
            <th class="center">Queue Time</th>
            <th class="center description">Ticket Description</th>
          </tr>
		  </thead>
		  <tbody>
			<?php
				$openTickets = $dao->getOpenTickets();
				for ($i = 0; $i < count($openTickets); $i++) {
          if ($openTickets[$i]["creator_user_id"] == $_SESSION["user"]["user_id"]) {
      ?>
				<tr>
          <td class="center"><?php echo ($i + 1); ?></td>
          <td class="center"><?php echo htmlspecialchars($openTickets[$i]["node_number"]); ?></td>
          <td class="center"><?php echo strtoupper(htmlspecialchars($openTickets[$i]["course_name"])); ?></td>
          <td class="center"><?php
            $updateDate = new DateTime($openTickets[$i]["update_date"]);
            echo $updateDate->format("g:i A F jS Y");
          ?></td>
          <td class="center">
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#ticketDescription">
                More Info
            </button>

            <!-- Modal -->
            <div class="modal fade" id="ticketDescription" tabindex="-1" role="dialog" aria-labelledby="ticketDescriptionTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                         </div>
                        <div class="modal-body"><?php echo htmlspecialchars($openTickets[$i]["description"]); ?>
                         </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         </div>
                     </div>
                 </div>
             </div>
           </td>
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
<div class="container-fluid">
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Teaching Assistants</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
					<td class="center"><?php echo htmlspecialchars($ta['first_name']) . " " . htmlspecialchars($ta['last_name']); ?></td>
					<td class="center"><?php echo htmlspecialchars($ta['email']); ?></td>
          <td class="center"><?php echo $startTime->format("g:i A") . " - " . $endTime->format("g:i A"); ?></td>
				<tr>
			<?php } ?>
		  </tbody>
		</table>
      </div>
     </div>
     </div>
    </div>
  </div>
	 </div>
	</div>
 </div>
 <?php require_once '../components/footer.php';require_once '../components/scripts.php'; ?>
