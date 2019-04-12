<?php $page = "my-ta-tickets.php";
    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();
 
    $my_ta_id = $_SESSION["user"]["user_id"];
    $my_course_id = $dao->getMyCourseID($my_ta_id);
    $myTickets = $dao->getMyOpenTickets($my_course_id['0']['available_course_id']);
    $cleanTickets = [
        "data" => array()
    ];

    // Sanitize the tickets
    $queue = 0;
    foreach ($myTickets as $ticket) {
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
        <button type="button" class="toggle-close-form btn btn-block bg-danger text-gray-100">
          <input id="open-ticket-id-info" type="hidden" value="' . $ticket['open_ticket_id'] . '"/>
          <input id="closer-user-id-info" type="hidden" value="' . $my_ta_id . '"/>
            Close Ticket
        </button>
        ';
        $cleanTickets["data"][] = $cleanTicket;
    }
    header("Content-Type: application/json");
    echo json_encode($cleanTickets);