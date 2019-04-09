<?php 
    session_start();
    $page = "bug-reports.php"; 
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
                            <th class="center">Creator</th>
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
                                            <h5 class="modal-title" id="exampleModalLongTitle">Answer to <?php echo htmlentities($bugReport["title"]); ?></h5>
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
                                <button
                                    type="button"
                                    class="btn btn-block bg-danger text-gray-100"
                                    data-toggle="modal"
                                    data-target="<?php echo "#confirmModalReOpen" . $bugReport["bug_report_id"]; ?>"
                                >Delete</button>
                                <div
                                    class="modal fade"
                                    id="<?php echo "confirmModalReOpen" . $bugReport["bug_report_id"]; ?>"
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
                                                <p>Are you sure you want to delete this bug report?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form method="POST" action="../handlers/delete-bug-report-handler.php">
                                                    <input type="hidden" name="bugReportId" value="<?php echo $bugReport["bug_report_id"]; ?>" />
                                                    <input type="hidden" name="bugReportTitle" value="<?php echo htmlentities($bugReport["title"]); ?>" />
                                                    <button type="submit" class="btn btn-success">
                                                        Confirm
                                                    </button>
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