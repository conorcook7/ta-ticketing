<?php
    session_start();
    require_once "../../components/server-functions.php";
    require_once "../../components/dao.php";

    $logger = getServerLogger();
    $dao = new Dao();

    // Check if it is an actual AJAX request
    // if (!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"] == ""){
    //     $logger->logWarn(basename(__FILE__) . ": User attempting to access handler page directly.");
    //     header("Location: ../../pages/403.php");
    //     exit();
    // }

    // If the request is found to be AJAX
    $closedTickets = $dao->getClosedTickets();
    $cleanTickets = [
        "data" => Array()
    ];

    for ($i = 0; $i < sizeof($closedTickets); $i++) {
        if ($closedTickets[$i]["student_user_id"] == $_SESSION["user"]["user_id"]) {
            $cleanTicket = Array();
            $cleanTicket["ticketNumber"] = $closedTickets[$i]["closed_ticket_id"];
            $cleanTicket["ticketCreator"] = htmlentities($closedTickets[$i]["student_first_name"] . " " . $closedTickets[$i]["student_last_name"]);
            $cleanTicket["ticketCloser"] = htmlentities($closedTickets[$i]["ta_first_name"] . " " . $closedTickets[$i]["ta_last_name"]);
            $cleanTicket["courseName"] = strtoupper(htmlentities($closedTickets[$i]["course_name"]));
            $dateSolved = new DateTime($closedTickets[$i]["update_date"]);
            $cleanTicket["dateSolved"] = $dateSolved->format("F jS Y \a\\t g:i A");
            $cleanTicket["ticketDescription"] = '
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#my-closed-ticket-' . $i . '">
                More Info
                </button>
                <!-- Modal -->
                <div class="modal fade" id="my-closed-ticket-' . $i . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">' . htmlentities($closedTickets[$i]['description']) . '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            $cleanTicket["closingDescription"] = '
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#closed-description' . $closedTickets[$i]["closed_ticket_id"] . '">
                More Info
                </button>
                <!-- Modal for closing descriptions-->
                <div class="modal fade" id="closed-description' . $closedTickets[$i]["closed_ticket_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Why this ticket was closed...</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">' . htmlentities($closedTickets[$i]["closing_description"]) . '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            $cleanTicket["action"] = '
                <form method="POST" action="../handlers/user-closed-ticket-handler.php">
                    <input type="hidden" name="closed_ticket_id" value="' . $closedTickets[$i]['closed_ticket_id'] . '"/>
                    <input type="hidden" name="student_user_id" value="' . $closedTickets[$i]['student_user_id'] . '" />
                    <button type="submit" class="btn btn-block btn-success">
                        <i class="fas fa-redo fa-xl text-white pr-2"></i>Reopen Ticket
                    </button>
                </form>
            ';
            $cleanTickets["data"][] = $cleanTicket;
        }
    }

    // Return the data
    header("Content-Type: application/json");
    echo json_encode($cleanTickets);