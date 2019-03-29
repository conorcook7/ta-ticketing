<?php $page = "open-tickets-table.php"; ?>
<div class="container-fluid">
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
                      <th class ="center">ID</th>
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center status">Status</th>
                      <th class="center description">Description</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $allOpenTickets = $dao->getOpenTickets();
                    $max = sizeof($allOpenTickets);
                    $queue = 0;
                    for ($index = 0; $index <= $max; $index++) {
                      if($allOpenTickets[$index]['online'] == 1){
                        $queue++;
                   ?>
                      <tr>
                      <form method="POST" action="../handlers/ta-handler.php"> <!-- need to add linking -->
                        <input type='hidden' name='open_ticket_id_input' value="<?php echo $allOpenTickets[$index]['open_ticket_id'];?>"/>
                        <input type='hidden' name='closer_id_input' value="<?php echo "$my_ta_id";?>"/>
                        <td class="center"><?php echo $queue?></td>
                        <td class="center"><?php echo $allOpenTickets[$index]['first_name'], " ", $allOpenTickets[$index]['last_name']?></td>
                        <td class="center"><?php echo $allOpenTickets[$index]['node_number']?></td>
                        <td class="center"><?php echo strtoupper($allOpenTickets[$index]['course_name'])?></td>
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
                            <button type="submit" class="btn btn-block bg-danger text-gray-100">
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
</div>