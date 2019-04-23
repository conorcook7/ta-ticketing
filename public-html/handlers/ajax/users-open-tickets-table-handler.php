<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */
    
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

    // If it is an AJAX request
    $openTickets = $dao->getOpenTickets();
    $cleanTickets = [
        "data" => Array()
    ];
    for ($i = 0; $i < sizeof($openTickets); $i++) {
        if ($openTickets[$i]["creator_user_id"] == $_SESSION["user"]["user_id"]) {
            $cleanTicket = Array();
            $cleanTicket["queue"] = ($i + 1);
            $cleanTicket["node"] = htmlentities($openTickets[$i]["node_number"]);
            $cleanTicket["courseName"] = strtoupper(htmlentities($openTickets[$i]["course_name"]));
            $queueTime = new DateTime($openTickets[$i]["update_date"]);
            $cleanTicket["queueTime"] = $queueTime->format("F jS Y \a\\t g:i A");
            $cleanTicket["ticketDescription"] = '
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#my-ticket-' . $i . '">
                More Info
                </button>
                <!-- Modal -->
                <div class="modal fade" id="my-ticket-' . $i .'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">' . htmlentities($openTickets[$i]["description"]) . '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
            $cleanTicket["action"] = '
                <form method="POST" action="../handlers/user-open-ticket-handler.php">
                    <input type="hidden" name="open_ticket_id" value="' . $openTickets[$i]["open_ticket_id"] . '"/>
                    <button type="submit" class="btn btn-block btn-danger">
                        <i class="fas fa-times fa-xl text-white pr-2"></i>Cancel Ticket
                    </button>
                </form>
            ';
            $cleanTickets["data"][] = $cleanTicket;
        }
    }

    // Return the data
    header("Content-Type: application/json");
    echo json_encode($cleanTickets);