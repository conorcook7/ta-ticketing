<?php

    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();

    // Check if it is an actual AJAX request
    if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"] == ""){
        $logger->logWarn(basename(__FILE__) . ": User attempting to access handler page directly.");
        header("Location: ../../pages/403.php");
        exit();
    }

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
        $cleanTicket["status"] = '
            <button type="button" class="btn btn-block bg-success text-gray-100" data-toggle="modal" data-target="#confirmModalReOpen' . $ticket["closed_ticket_id"] . '">
                Reopen Ticket
            </button>
            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmModalReOpen' . $ticket["closed_ticket_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Please Confirm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to reopen this ticket?</p>
                        </div>
                        <div class="modal-footer">
                            <form method="POST" action="../handlers/ticket-handler.php"> 
                                <input type="hidden" name="closed_ticket_id" value="' . $ticket["closed_ticket_id"] . '"/>
                                <input type="hidden" name="opener_id" value="' . $ticket["ta_user_id"] . '"/>
                                <button type="submit" class="btn btn-success">Confirm</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
        $cleanTickets["data"][] = $cleanTicket;
    }
    
    header("Content-Type: application/json");
    echo json_encode($cleanTickets);