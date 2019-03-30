<?php
  require_once '../components/header.php';
  $page = 'about.php';
  $nav = 'about';
?>

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Topbar -->
        <?php include_once '../components/topbar.php'; ?>
        <!-- End of Topbar -->

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid p-4">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">About Us</h1>
                </div>

                <div class="row">

                    <div class="col-xl-8 col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Project Overview</h6>
                            </div>
                            <div class="card-body">
                                <p>
                                The purpose of this website is to assist teaching assistants in more
                                efficiently helping students in need. This website will act as one of the
                                ways students, teaching assistants, and teachers may track problems that
                                are occurring in courses offered here at Boise State University.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Sponsor -->
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xl font-weight-bold text-primary text-uppercase mb-1">Sponsor</div>
                                        <div class="text-l mb-0 font-weight-bold text-gray-800">Benjamin Peterson</div>
                                        <div class="text-s mb-0 text-gray-800">IT Systems Engineer</div>
                                        <div class="text-s mb-0 text-gray-800">Information Technology Services/COEN</div>
                                        <a href="mailto: BenjaminPeterson@boisestate.edu">
                                            <div class="text-m mb-0 font-weight-bold text-gray-800">BenjaminPeterson@boisestate.edu</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                <!-- Row end -->
                </div>

                <div class="row">

                    <div class="col-xl-12 col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Meet the development team!</h6>
                            </div>
                            <div class="card-body">
                                <p>
                                We are students at Boise State University. Every computer science major
                                must complete a senior design project in which a team is formed around a particular
                                project. These projects are designed to be completed in one semester using
                                industry standards along the way.
                                </p>
                                <p>
                                This project gave our team the opportunity to help the future students with
                                struggles that we have been able to experience first hand. It has been fun and
                                frustrating at the same time, but overall we hope that you can enjoy
                                this website as much as we have!
                                </p>
                            </div>
                        </div>
                    </div>
                
                <!-- Row end -->
                </div>

                <div class="row">
                    <!-- Developer -->
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-4">
                                    <div class="col mr-2">
                                        <div class="text-l font-weight-bold text-danger text-uppercase mb-1">Conor Cook</div>
                                        <a href="mailto: conorcook@u.boisestate.edu">
                                            <span class="text-m mb-0 font-weight-bold text-gray-800">conorcook@u.boisestate.edu</span>
                                        </a>
                                    </div>
                                </div>
                                <p>
                                Bio
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Developer -->
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-4">
                                    <div class="col mr-2">
                                        <div class="text-l font-weight-bold text-success text-uppercase mb-1">Malik Herring</div>
                                        <a href="mailto: malikherring@u.boisestate.edu">
                                            <span class="text-m mb-0 font-weight-bold text-gray-800">malikherring@u.boisestate.edu</span>
                                        </a>
                                    </div>
                                </div>
                                <p>
                                Hey, good on you for looking into who made this page. A lot of my parts into this was
                                with creating the Admin page that only admins can see. I also assisted with debugging
                                and outside the box solutions to most problems.
                                </p>
                            </div>
                        </div>
                    </div>
                
                <!-- Row end -->
                </div>

          
                <div class="row">

                    <!-- Developer -->
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-4">
                                    <div class="col mr-2">
                                        <div class="text-l font-weight-bold text-info text-uppercase mb-1">Hayden Phothong</div>
                                        <a href="mailto: haydenphothong@u.boisestate.edu">
                                            <span class="text-m mb-0 mr-3 font-weight-bold text-gray-800">haydenphothong@u.boisestate.edu</span>
                                        </a>
                                    </div>
                                    <p>
                                    Hello! My role in creating this website was mostly back-end development.
                                    I helped create the database schema and assisted other developers with
                                    complex SQL queries. I also created the page you are looking at now!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Developer -->
                    <div class="col-xl-6 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center mb-4">
                                    <div class="col mr-2">
                                        <div class="text-l font-weight-bold text-warning text-uppercase mb-1">Michael Sanchez</div>
                                        <a href="mailto: michaelsanchez563@u.boisestate.edu">
                                            <span class="text-m mb-0 font-weight-bold text-gray-800">michaelsanchez563@u.boisestate.edu</span>
                                        </a>
                                    </div>
                                </div>
                                <p>
                                My role in this website was creating the page that general users see
                                when they are logged into the website. I also created and handled the
                                forms that users utilize when they are creating a new help ticket to be
                                reviewed. 
                                </p>
                            </div>
                        </div>
                    </div>

                <!-- Row end -->
                </div>

            </div>
            <!-- /.container-fluid -->

            <?php include_once '../components/footer.php' ?>
        
        </div>
        <!-- End of Main Content -->

        

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php require_once "../components/scripts.php"; ?>
