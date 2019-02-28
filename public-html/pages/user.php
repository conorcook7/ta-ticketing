<?php
  require_once '../components/header.php';
  require_once '../components/dao.php';
  $dao = new Dao("Dummy_TA_Ticketing")?>

<body id="page-top">

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
					<td><?php echo htmlspechialchars($ta['email']); ?></td>
				<tr>
			<?php } ?>
		  </tbody>
		</table>
	 </div>
	</div>
 </div>
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

<?php require_once '../components/footer.php'; ?>
</html>
