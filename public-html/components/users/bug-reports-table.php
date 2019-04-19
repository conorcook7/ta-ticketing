<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    session_start();
    $page = "bug-reports-table.php";
?>
<?php if (isset($_SESSION["bug-report-success"])){ ?>
    <div class="alert alert-success mx-4">
        <strong>Success!</strong> <?php echo $_SESSION["bug-report-success"]; ?>
    </div>
<?php } elseif (isset($_SESSION["bug-report-failure"])) { ?>
    <div class="alert alert-danger mx-4">
        <strong>Failure!</strong> <?php echo $_SESSION["bug-report-failure"]; ?>
    </div>
<?php }
    unset($_SESSION["bug-report-failure"]);
    unset($_SESSION["bug-report-success"]);
?>

<!-- Bug Report Closing Form -->
<div id="bug-reports-div" class="px-4 mb-4" style="display: none">
    <form method="POST" action="../handlers/resolve-bug-report-handler.php">
        <input type="hidden" name="bugReportId" id="bug-report-id" value="" />
        <input type="hidden" name="bugReportTitle" id="bug-report-title" value="" />
        <div>Bug Report ID: <span id="resolve-id"></span></div>
        <div>Bug Report Creator: <span id="resolve-user">No User</span></div>
        <div>Bug Report Title: <span id="resolve-title">No User</span></div>
        <label id="resolve-description-label" class="mt-4" for="closing-description">Closing Description</label>
        <textarea
            id="resolve-description"
            class="form-control w-50"
            name="resolveDescription"
            placeholder="What did you help solve?"
            maxlength=512
            rows=3
            required="true"></textarea>
        <button type="submit" id="resolve-submit" class="btn btn-primary my-2">Finish Resolving</button>
        <button type="button" id="resolve-cancel" class="btn btn-danger my-2">Cancel</button>
    </form>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Bug Reports</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Created By</th>
                            <th class="center">Issue</th>
                            <th class="center">Description</th>
                            <th class="center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $bugReports = $dao->getBugReports();
                        foreach($bugReports as $bugReport) { 
                    ?>
                        <tr>
                            <td><?php echo htmlentities($bugReport["bug_report_id"]); ?></td>
                            <td><?php echo htmlentities($bugReport["first_name"] . " " . $bugReport["last_name"]); ?></td>
                            <td><?php echo htmlentities($bugReport["title"]); ?></td>
                            <td class="center">
                                <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#answer<?php echo $bugReport["bug_report_id"]?>">
                                    Description
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="answer<?php echo $bugReport["bug_report_id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo htmlentities($bugReport["title"]); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo htmlspecialchars($bugReport["description"]);?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button type="button" id="resolve-button" class="btn btn-block bg-success text-gray-100 bug-report-resolve-btn">Resolve</button>   
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>