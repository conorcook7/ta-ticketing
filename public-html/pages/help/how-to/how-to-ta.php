<?php
    session_start();
    
    $permission = strtoupper($_SESSION["user"]["permission"]);
    if ($permission != "TA" && $permission != "ADMIN") {
        header("Location: ../403.php");
        exit();
    }
    ?>
<div class="tab-pane fade <?php if ($permission == 'TA') {echo 'active show';} ?>" id="nav-how-to-ta" role="tabpanel" aria-labelledby="nav-how-to-ta-tab">
    <!-- Close a ticket -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Close a ticket</h1>
        </div>
        <div class="card-body">
            <!-- <div class="card-title mb-4">
                <div class="text-gray-800">
                </div>
                </div> -->
            <div class="row">
                <!-- Step 1 - Locate the ticket in the table -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Locate the Ticket</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Locate the ticket in either the <strong class="text-gray-800">My Tickets</strong> or
                                <strong class="text-gray-800">All Open Tickets</strong> menus.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 - Close ticket button -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Close Ticket Button</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                On the same row as the ticket you are ready to close, press the <strong>Close Ticket</strong>
                                button. This will create a window for you to leave a quick description.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 - Closing description -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Leave a Note</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-align-left fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Write a note of what happened. This is so you will remember why you closed the ticket
                                later. There is a limit to how many words you can write, so be concise!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Open a ticket -->
    <!-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Open a ticket</h1>
        </div>
        <div class="card-body">
            
        </div>
        </div> -->
</div>
<div class="tab-pane fade" id="nav-how-to-user" role="tabpanel" aria-labelledby="nav-how-to-user-tab">
    <?php require_once "how-to/how-to-user.php"; ?>
</div>