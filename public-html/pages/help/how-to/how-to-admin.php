<?php
    session_start();
    
    if (strtoupper($_SESSION["user"]["permission"]) != "ADMIN") {
        header("Location: ../403.php");
        exit();
    }
    ?>
<div class="tab-pane fade show active" id="nav-how-to-admin" role="tabpanel" aria-labelledby="nav-how-to-admin-tab">
    <!-- Update a user -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Update a user</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Step 1 -->
                <div class="col-xl-6 col-md-8 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Find the User</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Navigate to the <strong class="text-gray-800">View Users</strong> page via the menu
                                on the left of your screen. Locate the row of the user in the
                                <strong class="text-gray-800">All Users</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-xl-6 col-md-8 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Update Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-warning disabled">Update User</span>
                                </div>
                            </div>
                            <p>
                                Click the <strong class="text-gray-800">Update User</strong> button that is on the same
                                row as the user you would like to update. This should show you a form with information
                                about the user.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Add/Update User Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-primary disabled">Add/Update User</span>
                                </div>
                            </div>
                            <p>
                                Once you have updated the information about the user, you may then click the
                                <strong class="text-gray-800">Add/Update User Button</strong> at the bottom.
                                This will check if the user email exists, upon finding a valid user it will then
                                update his/her information.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Close a Bug Report  -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Resolve a Bug Report</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Step 1 -->
                <div class="col-xl-5 col-md-5 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Locate the Bug Report</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                First, navigate to the <strong class="text-gray-800"><i class="fas fa-fw fa-bug"></i> Bug Reports</strong>
                                menu on the left of your screen. Locate the bug report in the 
                                <strong class="text-gray-800">All Bug Reports</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-xl-7 col-md-7 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Resolve Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-success disabled">Resolve</span>
                                </div>
                            </div>
                            <p>
                                Now that you have located the bug report that you would like to resolve, you are able
                                to click the <strong class="text-gray-800">Resolve</strong> button that corresponds to
                                the same row as the bug report you would like to close.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create a class -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Create a Class</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Step 1 -->
                <div class="col-xl-6 col-md-8 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Create a Class Page</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher"></i> Create/Delete Classes
                                </div>
                            </div>
                            <p>
                                Navigate to the <strong class="text-gray-800">View Users</strong> page via the menu
                                on the left of your screen. Locate the row of the user in the
                                <strong class="text-gray-800">All Users</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-xl-6 col-md-8 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Update Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-warning disabled">Update User</span>
                                </div>
                            </div>
                            <p>
                                Click the <strong class="text-gray-800">Update User</strong> button that is on the same
                                row as the user you would like to update. This should show you a form with information
                                about the user.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Add/Update User Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-primary disabled">Add/Update User</span>
                                </div>
                            </div>
                            <p>
                                Once you have updated the information about the user, you may then click the
                                <strong class="text-gray-800">Add/Update User Button</strong> at the bottom.
                                This will check if the user email exists, upon finding a valid user it will then
                                update his/her information.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete a Class -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Delete a Class</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Step 1 -->
                <div class="col-xl-6 col-md-8 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Find the User</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            <p>
                                Navigate to the <strong class="text-gray-800">View Users</strong> page via the menu
                                on the left of your screen. Locate the row of the user in the
                                <strong class="text-gray-800">All Users</strong> table.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-xl-6 col-md-8 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Update Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-warning disabled">Update User</span>
                                </div>
                            </div>
                            <p>
                                Click the <strong class="text-gray-800">Update User</strong> button that is on the same
                                row as the user you would like to update. This should show you a form with information
                                about the user.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-xl-12 col-md-12 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Add/Update User Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-primary disabled">Add/Update User</span>
                                </div>
                            </div>
                            <p>
                                Once you have updated the information about the user, you may then click the
                                <strong class="text-gray-800">Add/Update User Button</strong> at the bottom.
                                This will check if the user email exists, upon finding a valid user it will then
                                update his/her information.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "how-to/how-to-ta.php"; ?>