<?php
    session_start();
    require_once '../../components/header.php';
    $page = 'how-to-user.php';
    $nav = 'help';
    ?>
<!-- Create a ticket -->
<div class="<?php echo strtoupper($_SESSION["user"]["permission"]) == "USER" ? "row" : ""; ?>">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Create a ticket</h1>
        </div>
        <div class="card-body">
            <div class="card-title mb-4">
                <div class="text-gray-800">
                    In order to create a new ticket, you will need to follow 3 easy steps. These
                    steps are completed through the dashboard page. If you are a teaching assistant,
                    then you will need to complete these steps in the tickets page.
                </div>
            </div>
            <div class="row">
                <!-- Step 1 - Submit Button -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">New Ticket Button</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-plus-square fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Create a ticket with the <strong>New Ticket</strong> button at the top right of the
                                <strong>My Open Tickets</strong> table on your dashboard page.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 - Information -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Fill in Information</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Write about your issue so that the teaching assistant can start to become
                                familiar with your problem.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 - Wait for assistance -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Wait for Assistance</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>Continue working on other parts of the homework, while a teaching assistant
                                becomes available. You can always see the available teaching assistants in the
                                <strong>Available Teaching Assistants</strong> table below the <strong>My Closed Tickets</strong>
                                table on the dashboard page.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="<?php echo strtoupper($_SESSION["user"]["permission"]) == "USER" ? "row" : ""; ?>">
    <!-- Close a ticket -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Close your ticket</h1>
        </div>
        <div class="card-body">
            <div class="card-title mb-4">
                <div class="text-gray-800">
                    You have the option to close your own tickets. A great example is if you have
                    created a ticket, but figured out the answer on your own (<strong>nice job!</strong>).
                </div>
            </div>
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
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>You can browse to your dashboard using the navigation bar on the left side of your screen.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 - Information -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Find the Ticket</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                In order to close one of your own tickets, you need to find the ticket in the <strong>My Open Tickets</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 - Wait for assistance -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Close Ticket Button</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Simply press the <strong>Cancel Ticket</strong> button that is on the same row as the
                                ticket you would like to close. You should now be able to see the cancelled ticket in your
                                <strong>My Closed Tickets</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="<?php echo strtoupper($_SESSION["user"]["permission"]) == "USER" ? "row" : ""; ?>">
    <!-- Reopen a ticket -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Reopen your ticket</h1>
        </div>
        <div class="card-body">
            <div class="card-title mb-4">
                <div class="text-gray-800">
                    You have the option to open your old tickets that have been closed. Each closed
                    ticket will have a description stating the reason as to why the ticket was closed.
                </div>
            </div>
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
                                    <i class="fas fa-home fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>You can browse to your dashboard using the navigation bar on the left side of your screen.</p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 - Information -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Find the Ticket</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                In order to reopen one of your own tickets, you need to find the ticket in the <strong>My Closed Tickets</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 - Wait for assistance -->
                <div class="col-xl-4 col-md-6">
                    <div class="card border-left-primary h-100 floating-step">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Reopen Ticket Button</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-redo fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Simply press the <strong>Reopen Ticket</strong> button that is on the same row as the
                                ticket you found in Step 2. You should now be able to see the opened ticket in your
                                <strong>My Open Tickets</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>