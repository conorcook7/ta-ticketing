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

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid p-4">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">About Us</h1>
          </div>

          <div class="row">
            <!-- Approach -->
            <div class="card shadow col-xl-8 mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Project Overview</h6>
                </div>
                <div class="card-body">
                  <p>The purpose of this website is to assist teaching assistants in more
                  efficiently helping students in need.
                  </p>
                  <p></p>
                  <p>
                  </p>
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
          </div>

          <div class="row">
            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Meet the development team!</h6>
                </div>
                <div class="card-body">
                  <p>We are students at Boise State University. Every computer science major
                  must complete a senior design project in which a team is formed around a particular
                  project. These projects are designed to be completed in one semester using
                  industry standards along the way.
                  </p>
                  <p>This project gave our team the opportunity to help the future students with
                  struggles that we have been able to experience first hand. It has been fun and
                  frustrating at the same time, but overall we hope that you can enjoy
                  this website as much as we have!
                  </p>
                </div>
              </div>
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Developer -->
            <div class="col-xl-6 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center mb-4">
                    <div class="col mr-2">
                      <div class="text-l font-weight-bold text-danger text-uppercase mb-1">Conor Cook</div>
                      <a ref="mailto: conorcook@u.boisestate.edu">
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
                  Bio
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->
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
                  </div>
                  <p>
                    Hello! My role in creating this website was mostly back-end development.
                    I helped create the database schema and assisted other developers with
                    complex SQL queries. I also created the page you are looking at now!
                  </p>
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
                  Bio
                  </p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include_once '../components/footer.php' ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
