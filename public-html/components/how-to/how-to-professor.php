<?php
/**
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */
?>
<div class="tab-pane fade show active" id="nav-how-to-professor" role="tabpanel" aria-labelledby="nav-how-to-professor-tab">
    <!-- Semester Kickstart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Add a teaching assistant</h1>
        </div>
        <div class="card-body">
            <h5 class="card-title text-gray-800 mb-4">
                Welcome back! This section will help you kickoff the semster by adding your teaching assistants into the
                website. The process is quick and easy!
            </h5>
            <div class="row">
            <!-- Step 1 -->
            <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Have the TA login</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-sign-in-alt fa-2x"></i>
                                </div>
                            </div>
                            <p>
                                Let the teaching assistant know that he or she must log into the website (
                                <a href="https://taticketing.boisestate.edu">https://taticketing.boisestate.edu</a> )
                                at least once for the Google Authentication to verify the account.
                                
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 2</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Find the TA</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x"></i>
                                </div>
                            </div>
                            <p>
                                Navigate to the <strong class="text-gray-800">View Users</strong> page via the menu
                                on the left of your screen. Locate the row of the user in the
                                <strong class="text-gray-800">All Users</strong> table. (This process can also be done
                                from the <strong class="text-gray-800">View Online Users</strong> page if the TA is online).
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Update Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-warning disabled">Update User</span>
                                </div>
                            </div>
                            <p>
                                Click the <strong class="text-gray-800">Update User</strong> button that is on the same
                                row as the user you would like to update. This will show you a form with information
                                about that user.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 4</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Change to TA</div>
                                </div>
                                <div class="col-auto">
                                    <div class="form-control w-100">TA</div>
                                </div>
                            </div>
                            <p>
                                Change the <strong class="text-gray-800">Permission Level</strong> field to
                                <strong class="text-gray-800">TA</strong>. This will then display the
                                <strong class="text-gray-800">Course</strong> field that will need to be
                                changed to correspond with the teaching assitant's assigned class. (If the
                                course you would like to assign to the teaching assistant is not available,
                                you may report this issue
                                <a href="<?php echo generateUrl('/pages/help/bug-report.php'); ?>">here</a>.)
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Step 5 -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 5</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Finish Editing Button</div>
                                </div>
                                <div class="col-auto">
                                <span class="btn-sm btn-primary disabled">Finish Editing</span>
                                </div>
                            </div>
                            <p>
                                Lastly, you may click the <strong class="text-gray-800">Finish Editing</strong>
                                button at the bottom of the input fields. A submission message will show up at
                                the top of the page. It will notify you if the submission was a success, or
                                if it was unable to complete your submission.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Update a user -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Update a user</h1>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Step 1 -->
                <div class="col-xl-3 col-md-4 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 1</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Find the User</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list-alt fa-2x"></i>
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
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary h-100 py-2">
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
                <div class="col-xl-5 col-md-6 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 mb-4">
                                    <div class="h5 font-weight-bold text-primary text-uppercase mb-1">Step 3</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Finish Editing Button</div>
                                </div>
                                <div class="col-auto">
                                    <span class="btn-sm btn-primary disabled">Finish Editing</span>
                                </div>
                            </div>
                            <p>
                                Once you have updated the information about the user, you may then click the
                                <strong class="text-gray-800">Finish Editing</strong> button at the bottom.
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