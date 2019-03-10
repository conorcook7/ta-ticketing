<?php
  require_once '../../components/header.php';
  $page = 'faq.php';
  $nav = 'help';
?>

  <!-- Page Wrapper -->
  <div id="wrapper">



    <!-- Start of Sidebar -->
    <?php include_once '../../components/sidebar.php'; ?>
    <!-- End of Sidebar -->



    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

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
                  <p>Write about your issue so that the teaching assistant can start to become
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
                  <p>Continue working on other part of the homework, while a teaching assistant
                  becomes available.
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
      <?php include_once '../../components/footer.php' ?>
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
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../js/sb-admin-2.min.js"></script>

</body>

</html>