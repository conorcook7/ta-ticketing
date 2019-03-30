<?php
  require_once '../../components/header.php';
  $page = 'new-ticket.php';
  $nav = 'help';
?>

<div id="wrapper">

    <?php include_once '../../components/sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">

        <?php include_once '../../components/topbar.php'; ?>
        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid p-4">

                <!-- Submitting a ticket heading -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h1 class="h2 m-0 font-weight-bold text-primary">Creating a new ticket</h1>
                    </div>
                    <div class="card-body">
                        <p>
                        There are three easy steps that you need to follow in order to create
                        a new ticket. After creation, these tickets are queued for available teaching
                        assistants with the specific course you need help with. One thing to note is
                        that your ticket will be taken out of the queue if you leave the site, and
                        it will be placed at the end of the queue when you return to the site.
                        </p>
                    </div>
                </div>

                <!-- Submitting a ticket -->
                <div class="row">

                <!-- Step 1 - Submit Button -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
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
                            <p>Create a new ticket with the "New Ticket" button on your dashboard.</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 - Information -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
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
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
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
                            becomes available.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
            
        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->
    <?php include_once '../../components/footer.php'; ?>

</div>
<!-- End of Page Wrapper -->

<?php
  require_once "../../components/scripts.php";
?>