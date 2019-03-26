<?php

// Settings for the navbar
$nav = 'ta';
$page = 'ta.php';

require_once '../components/dao.php';
  try{
      $dao = new Dao('Dummy_TA_Ticketing');
      $users = $dao->getUsers();

      $my_ta_id = 1; //need a function for this
      $my_course_id = 1; //need a function for this

      $allOpenTickets = $dao->getOpenTickets();

      $myTickets = $dao->getMyOpenTickets($my_course_id);
      $closedTickets = $dao->getClosedTickets();
      
      // $availableTAs = $dao->getAvailableTeachingAssistants();
      // $availableCourses = $dao->getAvailableCourses();

  }catch(Exception $e) {
    echo 'Unable to get DAO information: ',  $e->getMessage(), "\n";
    exit(0);
  }
require_once '../components/header.php';
?>

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




          <!-- MY Open Tickets Table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">My Open Tickets</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class = "queue">Queue #</th>
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center description">Description</th>
                      <th class="center action">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $max1 = sizeof($myTickets);
                    $queue1 = 0;
                    for ($index = 0; $index <= $max1; $index++) {
                      if($myTickets[$index]['online'] == 1){
                        $queue1++;
                   ?>
                      <tr>
                      <form method="POST" action="../handlers/ta-handler.php"> 
                        <input type='hidden' name='my_open_ticket_id_input' value="<?php echo $myTickets[$index]['open_ticket_id'];?>"/>
                        <input type='hidden' name='my_closer_id_input' value="<?php echo "$my_ta_id";?>"/>
                        <td class="center"><?php echo $queue1?></td>
                        <td class="center"><?php echo $myTickets[$index]['first_name'], " ", $myTickets[$index]['last_name']?></td>
                        <td class="center"><?php echo $myTickets[$index]['node_number']?></td>
                        <td class="center"><?php echo strtoupper($myTickets[$index]['course_name'])?></td>
                        <td class="center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-block bg-gradient-primary text-gray-100" data-toggle="modal" data-target="#exampleModalCenter">
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
                                        <div class="modal-body"><?php echo $myTickets[$index]['description']?>
                                         </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            </td>
                          <th class="center">
                            <button type="submit" class="btn btn-block bg-gradient-danger text-gray-100 closeTickets">
                                Close Ticket
                            </button>
                           </th>
                          </form> 
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
          <!-- End of MY open tickets -->




          <!-- All Open Tickets Table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Open Tickets</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class = "queue">Queue #</th>
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center description">Description</th>
                      <th class="center action">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $max = sizeof($allOpenTickets);
                    $queue = 0;
                    for ($index = 0; $index <= $max; $index++) {
                      if($allOpenTickets[$index]['online'] == 1){
                        $queue++;
                   ?>
                      <tr>
                      <form method="POST" action="../handlers/ta-handler.php"> 
                        <input type='hidden' name='open_ticket_id_input' value="<?php echo $allOpenTickets[$index]['open_ticket_id'];?>"/>
                        <input type='hidden' name='closer_id_input' value="<?php echo "$my_ta_id";?>"/>
                        <td class="center"><?php echo $queue?></td>
                        <td class="center"><?php echo $allOpenTickets[$index]['first_name'], " ", $allOpenTickets[$index]['last_name']?></td>
                        <td class="center"><?php echo $allOpenTickets[$index]['node_number']?></td>
                        <td class="center"><?php echo strtoupper($allOpenTickets[$index]['course_name'])?></td>
                        <td class="center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-block bg-gradient-primary text-gray-100" data-toggle="modal" data-target="#exampleModalCenter">
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
                          <th class="center">
                            <button type="submit" class="btn btn-block bg-gradient-danger text-gray-100">
                                Close Ticket
                            </button>
                           </th>
                          </form> 
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
          <!-- End of All open tickets -->



          
          <!-- All Closed Tickets Table -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Closed Tickets</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Student Name</th>
                      <th class="center">Teaching Assistant</th>
                      <th class="center nodeInfo">Course</th>
                      <th class="center courseInfo">Date Solved</th>
                      <th class="center description">Description</th>
                      <th class="center action">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $max3 = sizeof($closedTickets);
                    for ($index = 0; $index <= $max3; $index++) {
                   ?>
                      <tr>
                       <form method="POST" action="../handlers/ta-handler.php"> 
                        <input type='hidden' name='closed_ticket_id' value="<?php echo $closedTickets[$index]['closed_ticket_id'];?>"/>
                        <input type='hidden' name='opener_id' value="<?php echo $closedTickets[$index]['ta_user_id'];?>"/>
                        <td class="center"><?php echo $closedTickets[$index]['student_first_name'], " ", $closedTickets[$index]['student_first_name']?></td>
                        <td class="center"><?php echo $closedTickets[$index]['ta_first_name'], " ", $closedTickets[$index]['ta_last_name']?></td>
                        <td class="center"><?php echo strtoupper($closedTickets[$index]['course_name'])?></td>
                        <td class="center"><?php echo strtoupper($closedTickets[$index]['update_date'])?></td>
                        <td class="center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-block bg-gradient-primary text-gray-100" data-toggle="modal" data-target="#exampleModalCenter">
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
                                        <div class="modal-body"><?php echo $closedTickets[$index]['description']?>
                                         </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            </td>
                          <th class="center">
                            <button type="submit" class="btn btn-block bg-gradient-success text-gray-100">
                                Reopen Ticket
                            </button>
                           </th>
                        </form> 
                       </tr>
                    <?php
                    if($index == 500){
                      break;
                    }
                    }?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- End of Closed tickets. -->





        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

     <!-- Footer -->
     <?php include_once '../components/footer.php' ?>
     <!-- End of Footer -->

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

<!-- Scripts -->
<?php include_once '../components/scripts.php' ?>
<!-- End of Scripts -->

