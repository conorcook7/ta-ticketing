<?php
/**
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */
?>
<div class="tab-pane fade <?php if ($permission == 'USER') {echo 'active show';} ?>" id="nav-how-to-user" role="tabpanel" aria-labelledby="nav-how-to-user-tab">

    <!-- Create a ticket -->
    <div class="<?php echo strtoupper($_SESSION["user"]["permission"]) == "USER" ? "row" : ""; ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h2 m-0 font-weight-bold text-primary">Create a ticket</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Step 1 - Submit Button -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">New Ticket Button</div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="btn-sm btn-success disabled"><i class="fas fa-plus-square"></i> Create New Ticket</span>
                                    </div>
                                </div>
                                <p>
                                    Create a ticket with the <strong class="text-gray-800">Create New Ticket</strong> button
                                    at the top right of the <strong class="text-gray-800">My Open Tickets</strong> table on
                                    your dashboard page.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2 - Information -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Fill in Information</div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="btn-sm btn-primary disabled">Submit</span>
                                    </div>
                                </div>
                                <p>
                                    Write about your issue in the <strong class="text-gray-800">Problem Description</strong>
                                    so that the teaching assistant can start to become familiar with your problem. When you
                                    are done, click the <strong class="text-gray-800">Submit</strong> button.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Step 3 - Wait for assistance -->
                    <div class="col-xl-6 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Wait for Assistance</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                </div>
                                <p>
                                    Continue working on other parts of the homework, while a teaching assistant
                                    becomes available. You can always see the available teaching assistants in the
                                    <strong class="text-gray-800">Available Teaching Assistants</strong> table below
                                    the <strong class="text-gray-800">My Closed Tickets</strong> table on the dashboard
                                    page. If the table is empty, then there are no teaching assistants working at the moment.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Close a ticket -->
    <div class="<?php echo strtoupper($_SESSION["user"]["permission"]) == "USER" ? "row" : ""; ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h2 m-0 font-weight-bold text-primary">Close your ticket</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Step 1 - Submit Button -->
                    <div class="col-xl-4 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Go to Your Dashboard</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user fa-2x"></i>
                                    </div>
                                </div>
                                <p>
                                    You are able to browse to your dashboard by clicking on the
                                    <strong class="text-gray-800"><i class="fas fa-user"></i> Student Dashboard</strong>
                                    using the navigation bar on the left side of your screen.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Step 2 - Information -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Find the Ticket</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-list-alt fa-2x"></i>
                                    </div>
                                </div>
                                <p>
                                    In order to close one of your own tickets, you need to find the ticket in the
                                    <strong class="text-gray-800">My Open Tickets</strong> table.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Step 3 - Wait for assistance -->
                    <div class="col-xl-5 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Cancel Ticket Button</div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="btn-sm btn-danger disabled"><i class="fas fa-times"></i> Cancel Ticket</span>
                                    </div>
                                </div>
                                <p>
                                    Simply press the <strong class="text-gray-800">Cancel Ticket</strong> button that is
                                    on the same row as the ticket you would like to close. You should now be able to see
                                    the cancelled ticket in your <strong class="text-gray-800">My Closed Tickets</strong> table.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reopen a ticket -->
    <div class="<?php echo strtoupper($_SESSION["user"]["permission"]) == "USER" ? "row" : ""; ?>">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h2 m-0 font-weight-bold text-primary">Reopen your ticket</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Go to Your Dashboard</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user fa-2x"></i>
                                    </div>
                                </div>
                                <p>
                                    You are able to browse to your dashboard by clicking on the
                                    <strong class="text-gray-800"><i class="fas fa-user"></i> Student Dashboard</strong>
                                    using the navigation bar on the left side of your screen.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Find the Ticket</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-list-alt fa-2x"></i>
                                    </div>
                                </div>
                                <p>
                                    In order to reopen one of your own tickets, you need to find the ticket in the
                                    <strong class="text-gray-800">My Closed Tickets</strong> table.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-6">
                        <div class="card border-left-primary h-100 floating-step">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2 mb-4">
                                        <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Reopen Ticket Button</div>
                                    </div>
                                    <div class="col-auto">
                                        <span class="btn-sm btn-success disabled"><i class="fas fa-redo"></i> Reopen Ticket</span>
                                    </div>
                                </div>
                                <p>
                                    Simply press the <strong class="text-gray-800">Reopen Ticket</strong> button that is on
                                    the same row as the ticket you found in Step 2. You should now be able to see the
                                    opened ticket in your <strong class="text-gray-800">My Open Tickets</strong> table.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>