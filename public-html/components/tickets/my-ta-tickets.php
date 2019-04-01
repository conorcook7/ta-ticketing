<?php $page = "my-ta-tickets.php";
$myTickets = $dao->getMyOpenTickets($my_course_id);
$my_ta_id = $_SESSION[user][user_id];
// $myID = $_SESSION[user][user_id];
 ?>
<div class="container-fluid">  
        <!-- Start of My Tickets Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">My Open Tickets</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class = "queue">Queue</th>
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center description">Description</th>
                      <th class="center action">Status</th>
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
                            <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#exampleModalCenter">
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
                            <button type="button" class="btn btn-block bg-danger text-gray-100" data-toggle="modal" data-target="#confirmModal">
                                Close Ticket
                            </button>
                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                 <div class="modal-header">
                                  <h5 class="modal-title">Please Confirm</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                  <div class="modal-body">
                                    <p>Are you sure you want to close this ticket?</p>
                                   </div>
                                   <div class="modal-footer">
                                   <button type="submit" class="btn btn-success">Confirm</button>
                                   <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                   </div>
                                  </div>
                                </div>
                              </div>
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
        </div>