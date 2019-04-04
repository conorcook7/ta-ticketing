<?php 
    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();

    $closedTickets = $dao->getClosedTickets();
    //$openTickets = $dao->getOpenTickets();
    $cleanTickets = [
        "data" => array()
    ];
    /*
    foreach ($openTickets as $ticket) {
        $cleanTicket = Array();
        $cleanTicket["id"] = $ticket['open_ticket_id'];
        $cleanTicket["studentName"] = htmlentities($ticket["first_name"] . " " . $ticket["last_name"]);
        $cleanTicket["nodeNumber"] = $ticket['node_number'];
        $cleanTicket["course"] = htmlentities($ticket["course_name"]);
        $cleanTicket["status"] = 'Open';
        $cleanTicket["ticketDescription"] = '
            <!-- Button trigger modal for ticket descriptions-->
            <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#ticket-description-OPEN' . $ticket["open_ticket_id"] . '">
                <i class="fas fa-share pr-2"></i>
                Click Here
            </button>
            <!-- Modal for ticket descriptions-->
            <div class="modal fade" id="ticket-description-OPEN' . $ticket["open_ticket_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
        $cleanTickets["data"][] = $cleanTicket;
    }
    */
    foreach ($closedTickets as $ticket) {
        $cleanTicket = Array();
        $cleanTicket["id"] = $ticket["closed_ticket_id"];
        $cleanTicket["studentName"] = htmlentities($ticket["student_first_name"] . " " . $ticket["student_last_name"]);
        $cleanTicket["nodeNumber"] = htmlentities($ticket["node_number"]);
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
        $cleanTicket["status"] = 'Closed';
        $cleanTickets["data"][] = $cleanTicket;
    }

    header("Content-Type: application/json");
    echo json_encode($cleanTickets);
?>