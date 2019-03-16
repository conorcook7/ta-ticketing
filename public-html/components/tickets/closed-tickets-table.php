<?php $page = "closed-tickets-table.php"; ?>
<div class="container-fluid">
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
                    $closedTickets = $dao->getClosedTickets();
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