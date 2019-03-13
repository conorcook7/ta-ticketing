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
      <h6 class="m-0 font-weight-bold text-primary">Available Courses</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
		    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
          <tr>
            <th class="center">Course Name</th>
            <th  class="center description">Course Description</th>
          </tr>
		  </thead>
		  <tbody>
			<?php
				$courses = $dao->getAvailableCourses();
				foreach($courses as $course){?>
				<tr>
          <td class="center"><?php echo htmlspecialchars($course['course_name']); ?></td>
          <td class="center">
            <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                More Info
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                         </div>
                        <div class="modal-body"><?php echo 'Test Text'?>
                         </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         </div>
                     </div>
                 </div>
             </div>
           </td>
				</tr>
			<?php } ?>
		  </tbody>
		</table><br />
  </div>
  </div>
</div>
</div>
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
				foreach($tas as $ta){?>
				<tr>
					<td class="center"><?php echo htmlspecialchars($ta['first_name']) . " " . htmlspecialchars($ta['last_name']); ?></td>
					<td class="center"><?php echo htmlspecialchars($ta['email']); ?></td>
          <td class="center"><?php echo htmlspecialchars($ta['start_time_past_midnight']) . "-" . htmlspecialchars($ta['end_time_past_midnight']); ?></td>
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
 <?php require_once '../components/footer.php';require_once '../components/scripts.php'; ?>
