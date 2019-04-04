<?php
require_once "../../components/dao.php";
// DB table to use
$table = "Closed_Tickets";
 
// Table"s primary key
$primaryKey = "closed_ticket_id";
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array(
        "db" => "creator_user_id",
        "dt" => 0,
        "formatter" => function($data, $row) {
            $dao = new Dao();
            $user = $dao->getUserById($data);
            return htmlentities($user["first_name"] . " " . $user["last_name"]);
        }
    ),
    array(
        "db" => "closer_user_id",
        "dt" => 1,
        "formatter" => function($data, $row) {
            $dao = new Dao();
            $user = $dao->getUserById($data);
            return htmlentities($user["first_name"] . " " . $user["last_name"]);
        }
    ),
    array(
        "db" => "position",
        "dt" => 2,
        "formatter" => function($data, $row) {
            $dao = new Dao();
            $course = $dao->getAvailableCourseById($data);
            return htmlentities(strtoupper($course["course_name"]));
        }
    ),
    array(
        "db" => "description",
        "dt" => 3,
        "formatter" => function($data, $row) {
            return '
                <!-- Button trigger modal for ticket descriptions-->
                <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#ticket-description' . sha1($data) . '">
                    <i class="fas fa-share pr-2"></i>
                    Click Here
                </button>
                <!-- Modal for ticket descriptions-->
                <div class="modal fade" id="ticket-description' . sha1($data) . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">' . htmlentities($data) . '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    ),
    array(
        "db" => "closing_description",
        "dt" => 4,
        "formatter" => function($data, $row) {
            return '
                <!-- Button trigger modal for closing descriptions -->
                <button type="button" class="btn btn-block bg-info text-gray-100" data-toggle="modal" data-target="#closed-description' . sha1($data) . '">
                    <i class="fas fa-exclamation-circle pr-2"></i>
                    Click Here
                </button>
                <!-- Modal for closing descriptions-->
                <div class="modal fade" id="closed-description' . sha1($data) . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Why this ticket was closed...</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">' . htmlentities($data) . '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    ),
    array(
        "db" => "closed_ticket_id",
        "dt" => 5,
        "formatter" => function($data, $row) {
            session_start();
            return '
                <button type="button" class="btn btn-block bg-success text-gray-100" data-toggle="modal" data-target="#confirmModalReOpen' . $ticket["closed_ticket_id"] . '">
                    <i class="fas fa-redo text-white pr-2"></i>
                    Reopen Ticket
                </button>
                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmModalReOpen' . $data . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                <form method="POST" action="../handlers/ta-handler.php"> 
                                    <input type="hidden" name="closed_ticket_id" value="' . $data . '"/>
                                    <input type="hidden" name="opener_id" value="' . $_SESSION["user"]["user_id"] . '"/>
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    )
);
 
// SQL server connection information
$sql_details = array(
    "user" => "ta-ticketing",
    "pass" => "34$5iu98&7o7%76d4Ss35",
    "db"   => "Dummy_TA_Ticketing",
    "host" => "localhost"
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( "../../components/ssp.class.php" );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);