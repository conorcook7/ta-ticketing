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

		<table class="table">
          <thead>
          <tr>
            <th scope="col">Course Name</th>
            <th scope="col">Course Number</th>
          </tr>
		  </thead>
		  <tbody>
			<?php
				$courses = $dao->getAvailableCourses();
				foreach($courses as $course){?>
				<tr>
          <td><?php echo htmlspecialchars($course['course_name']); ?></td>
					<td><?php echo htmlspecialchars($course['course_number']); ?></td>
				</tr>
			<?php } ?>
		  </tbody>
		</table><br />
		<table class = "table">
		  <thead>
		  <tr>
		  	<th scope = "col">Name</th>
			  <th scope = "col">Email</th>
		  </tr>
		  </thead>
		  <tbody>
			<?php
				$tas = $dao->getAvailableTeachingAssistants();
				foreach($tas as $ta){?>
				<tr>
					<td><?php echo htmlspecialchars($ta['first_name']) . " " . htmlspecialchars($ta['last_name']); ?></td>
					<td><?php echo htmlspecialchars($ta['email']); ?></td>
				<tr>
			<?php } ?>
		  </tbody>
		</table>
	 </div>
	</div>
 </div>
