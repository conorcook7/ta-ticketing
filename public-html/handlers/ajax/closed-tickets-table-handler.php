<?php
    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();

    $closedTickets = $dao->getClosedTickets();
    $cleanTickets = [
        "data" => array()
    ];

    // Sanitize the tickets
    foreach ($closedTickets as $ticket) {
        $cleanTicket = Array();
        $cleanTicket["id"] = $ticket["closed_ticket_id"];
        $cleanTicket["studentName"] = htmlentities($ticket["student_first_name"] . " " . $ticket["student_last_name"]);
        $cleanTicket["teachingAssistant"] = htmlentities($ticket["ta_first_name"] . " " . $ticket["ta_last_name"]);
        $cleanTicket["course"] = htmlentities($ticket["course_name"]);
        $cleanTicket["ticketDescription"] = '
            <!-- Button trigger modal for ticket descriptions-->
            <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#ticket-description' . $ticket["closed_ticket_id"] . '">
                <i class="fas fa-share pr-2"></i>
                Click Here
            </button>
            <!-- Modal for ticket descriptions-->
            <div class="modal fade" id="ticket-description' . $ticket["closed_ticket_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">' . htmlentities($ticket["description"]) . '</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $cleanTicket["closingRemarks"] = '
            <!-- Button trigger modal for closing descriptions -->
            <button type="button" class="btn btn-block bg-info text-gray-100" data-toggle="modal" data-target="#closed-description' . $ticket["closed_ticket_id"] . '">
                <i class="fas fa-exclamation-circle pr-2"></i>
                Click Here
            </button>
            <!-- Modal for closing descriptions-->
            <div class="modal fade" id="closed-description' . $ticket["closed_ticket_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Why this ticket was closed...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">' . htmlentities($ticket["closing_description"]) . '</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $cleanTicket["closeTicket"] = '
        <button type="button" class="btn btn-block bg-danger text-gray-100" data-toggle="modal" data-target="#confirmModalAllTicket'.$index .'">
          <i class="fas fa-times text-white pr-2"></i>  
            Close Ticket
        </button>
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModalAllTicket'.$index.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to close this ticket?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
             </div>
              <div class="modal-body">
                  <textarea placeholder="Please describe how you helped with this ticket..." required form="all_ticket_form<?php echo $index?>" name="limitedtextarea" class="form-control"  rows="5" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,500);" 
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
        ';
        $cleanTickets["data"][] = $cleanTicket;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanTickets);