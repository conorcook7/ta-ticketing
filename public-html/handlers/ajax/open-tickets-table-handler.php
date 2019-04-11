<?php
    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();
 
    $my_ta_id = $_SESSION["user"]["user_id"];
    $openTickets = $dao->getOpenTickets();
    $cleanTickets = [
        "data" => array()
    ];

    // Sanitize the tickets
    $queue = 0;
    foreach ($openTickets as $ticket) {
        $queue++;
        $cleanTicket = Array();
        $cleanTicket["queue"] = $queue;
        $cleanTicket["studentName"] = htmlentities($ticket["first_name"] . " " . $ticket["last_name"]);
        $cleanTicket["nodeInfo"] = htmlentities($ticket["node_number"]);
        $cleanTicket["course"] = htmlentities($ticket["course_name"]);
        $cleanTicket["ticketDescription"] = '
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#ticket-description-all' . $queue . '">
            Click Here
        </button>

        <!-- Modal -->
        <div class="modal fade" id="ticket-description-all' . $queue . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                     </button>
                     </div>
                    <div class="modal-body">
                      ' . htmlspecialchars($ticket['description']) . '
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                 </div>
             </div>
         </div>
        ';
        $cleanTicket["status"] = '
        <button type="button" class="btn btn-block bg-danger text-gray-100" data-toggle="modal" data-target="#confirmModalAllTicket' . $queue . '">
            Close Ticket
        </button>
        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmModalAllTicket' . $queue . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="POST" action="../handlers/ticket-handler.php" id="all_ticket_form' . $queue . '">
                <input type="hidden" name="open_ticket_id_input" value="' . $ticket['open_ticket_id'] . '"/>
                <input type="hidden" name="closer_id_input" value="' . $my_ta_id . '"/>
             <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to close this ticket?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
             </div>
              <div class="modal-body">
                  <textarea placeholder="Please describe how you helped with this ticket..." required form="all_ticket_form' . $queue . '" name="limitedtextarea" class="form-control"  rows="5" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,500);" 
                        onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,500);"></textarea>
                 
               </div>
               <div class="modal-footer">
                  <div class="mr-auto">
                    <span>(Maximum characters: 500)</span><br>
                    <span>You have <input class="removeStyling" readonly type="text" name="countdown" size="2" value="500"> characters left.</span>
                   </div>
                  <button type="submit" class="btn btn-success">Confirm</button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
               </div>
              </div>
              </form>
            </div>
          </div>
        ';
        $cleanTickets["data"][] = $cleanTicket;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanTickets);