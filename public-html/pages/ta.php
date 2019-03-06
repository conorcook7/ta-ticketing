<?php
require_once '../components/dao.php';
try{
$dao = new Dao('Dummy_TA_Ticketing');
$users = $dao->getUsers();
$availableTAs = $dao->getAvailableTeachingAssistants();
$allOpenTickets = $dao->getOpenTickets();
$availableCourses = $dao->getAvailableCourses();
}catch(Exception $e) {
    echo 'Unable to get DAO information: ',  $e->getMessage(), "\n";
    exit(0);
}
require_once '../components/header.php';
?>


<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">


    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php';?>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">



        <!-- Topbar -->
        <?php include_once '../components/topbar.php'; ?>
        <!-- End of Topbar -->

    

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Open Tickets</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class = "queue">Queue #</th>
                      <!-- <th>Ticket ID</th> -->
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center description">Description</th>
                      <th class="center action">Action</th>
                    </tr>
                  </thead>
                  <!-- <tfoot>
                    <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Salary</th>
                    </tr>
                  </tfoot> -->
                  <tbody>
                  <?php 
                    $max = sizeof($allOpenTickets);
                    $queue = 0;
                    for ($index = 0; $index <= $max; $index++) {
                      if($allOpenTickets[$index]['online'] == 1){
                        $queue++;
                   ?>
                      <tr>
                      <td class="center"><?php echo $queue?></td>
                      <!-- <td><?php //echo $allOpenTickets[$index]['open_ticket_id']?></td> -->
                      <td class="center"><?php echo $allOpenTickets[$index]['first_name'], " ", $allOpenTickets[$index]['last_name']?></td>
                      <td class="center"><?php echo $allOpenTickets[$index]['node_number']?></td>
                      <td class="center"><?php echo strtoupper($allOpenTickets[$index]['course_name'])?></td>
                      <td class="center">
                            <!-- Button trigger modal -->
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
                                        <div class="modal-body"><?php echo $allOpenTickets[$index]['description']?>
                                         </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                      </td>
                      <th class="center"><button type="button" class="btn btn-block btn-danger"">
                                Close Ticket
                            </button></th>
                    </tr>
                    <?php
                    }
                    if($index == 500){
                      break;
                    }
                    }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

<!-- Footer -->
<?php include_once '../components/footer.php' ?>
<!-- End of Footer -->

