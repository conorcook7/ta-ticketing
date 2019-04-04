<?php $page = "my-ta-tickets.php";
$my_ta_id = $_SESSION[user][user_id];
$my_course_id = $dao->getMyCourseID($my_ta_id);
$myTickets = $dao->getMyOpenTickets($my_course_id['0']['available_course_id']);
 ?>
<div class="container-fluid">  
        <!-- Start of My Tickets Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">My Open Tickets </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="queue">Queue</th>
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center description">Ticket Description</th>
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
                              <i class="fas fa-share pr-2"></i>
                                Click Here
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
                            <button type="button" class="btn btn-block bg-danger text-gray-100" data-toggle="modal" data-target="#confirmModalMyTicket<?php echo $index?>">
                              <i class="fas fa-times text-white pr-2"></i>  
                                Close Ticket
                            </button>
                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmModalMyTicket<?php echo $index?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                 <div class="modal-header">
                                  <h5 class="modal-title">Are you sure you want to close this ticket?</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                  <div class="modal-body">
                                    <textarea placeholder="Please describe how you helped with this ticket..." name="limitedtextarea" class="form-control"  rows="5" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,500);" 
                                            onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,500);"></textarea>
                                             
                                   </div>
                                   <div class="modal-footer">
                                      <div class="mr-auto">
                                        <span>(Maximum characters: 500)</span><br>
                                        <span>You have <input readonly type="text" name="countdown" size="3" value="500"> characters left.</span>
                                       </div>
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