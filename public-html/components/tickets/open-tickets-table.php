<?php $page = "open-tickets-table.php"; ?>
<!-- <script>
 function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
 </script> -->
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
                      <th class ="center">Queue</th>
                      <th class="center">Student Name</th>
                      <th class="center nodeInfo">Node</th>
                      <th class="center courseInfo">Course</th>
                      <th class="center status">Ticket Description</th>
                      <th class="center description">Status</th>
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
                                        <div class="modal-body">
                                          <?php echo $allOpenTickets[$index]['description']?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            </td>
                          <th class="center">
                            <button type="button" class="btn btn-block bg-danger text-gray-100" data-toggle="modal" data-target="#confirmModalAllTicket<?php echo $index?>">
                              <i class="fas fa-times text-white pr-2"></i>  
                                Close Ticket
                            </button>
                            <!-- Confirmation Modal -->
                            <div class="modal fade" id="confirmModalAllTicket<?php echo $index?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
          <!-- End of All open tickets -->
</div>