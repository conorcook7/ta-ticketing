<?php
/**
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */

session_start();
$page = 'blacklist.php';

// If the success/failure alert was triggered
if (isset($_SESSION["blacklist-success"])){ ?>
    <div class="alert alert-success mx-4">
        <strong>Success!</strong> <?php echo $_SESSION["blacklist-success"]; ?>
    </div>
<?php } elseif (isset($_SESSION["blacklist-failure"])) { ?>
    <div class="alert alert-danger mx-4">
        <strong>Failure!</strong> <?php echo $_SESSION["blacklist-failure"]; ?>
    </div>
<?php }
    unset($_SESSION["blacklist-failure"]);
    unset($_SESSION["blacklist-success"]);
?>

<!-- Blacklist Add/Update Form -->
<div id="blacklist-div" class="px-4 mb-4" style="display: none">
    <form method="POST" action="../handlers/blacklist-handler.php">
        <input type="hidden" id="blacklist-id" name="blacklistId" />
        <label id="blacklist-label" for="blacklistEmail">Email to blacklist</label>
        <input type="email" id="blacklist-email" class="form-control w-50" name="blacklistEmail" placeholder="Type email here..." maxlength=512 required="true" />
        <div class="d-flex justify-content-start w-50">
            <button type="submit" id="blacklist-submit" class="btn btn-primary my-2 mr-2">Add Email</button>
            <button type="button" class="btn btn-danger my-2 hide-form">Cancel</button>
        </div>
    </form>
</div>

<!-- Blacklist Table -->
<div class="container-fluid mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Blacklisted Emails</h6>
            <span>
                <button type="button" id="blacklist-add-btn" class="btn btn-success">
                    <i class="fas fa-plus-square fa-xl text-white pr-2"></i>Add Email
                </button>
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Blacklisted Email</th>
                            <th class="text-center">Blacklist Date</th>
                            <th class="text-center">Created By</th>
                            <th class="text-center">Update</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $blacklistEntries = $dao->getBlacklistEntries();
                        foreach($blacklistEntries as $blacklistEntry) {
                            $updateDate = new DateTime($blacklistEntry["update_date"]);
                    ?>
                        <tr>
                            <td class="text-center"><?php echo htmlentities($blacklistEntry["blacklist_id"]); ?></td>
                            <td class="text-center"><?php echo "<a href='mailto: " . htmlentities($blacklistEntry["blacklist_email"]) . "'>" . htmlentities($blacklistEntry["blacklist_email"]) . "</a>"; ?></td>
                            <td class="text-center"><?php echo $updateDate->format("F jS, Y @ g:i A"); ?></td>
                            <td class="text-center"><?php echo "<a href='mailto: " . htmlentities($blacklistEntry["email"]) . "'>" . htmlentities($blacklistEntry["email"]) . "</a>"; ?></td>
                            <td>
                                <button type="button" class="blacklist-update-btn btn btn-warning btn-block text-white">Update Email</button>
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-block bg-danger text-white"
                                    data-toggle="modal"
                                    data-target="<?php echo "#confirmModal" . $blacklistEntry["blacklist_id"]; ?>"
                                >Delete</button>
                                <div
                                    class="modal fade"
                                    id="<?php echo "confirmModal" . $blacklistEntry["blacklist_id"]; ?>"
                                    tabindex="-1"
                                    role="dialog"
                                    aria-labelledby="exampleModalCenterTitle"
                                    aria-hidden="true"
                                >
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Please Confirm</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Email: <strong class="text-gray-800"><?php echo htmlentities($blacklistEntry["blacklist_email"]); ?></strong></p>
                                                <p>Are you sure you want to remove this email from the list of emails that are unable to access the website?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="../handlers/blacklist-handler.php">
                                                    <input type="hidden" name="blacklistId" value="<?php echo $blacklistEntry["blacklist_id"]; ?>" />
                                                    <button type="submit" class="btn btn-success">Confirm</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>