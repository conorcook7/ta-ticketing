<?php
  require_once '../../components/dao.php';
  require_once '../../components/header.php';
  $page = 'faq.php';
  $nav = 'help';
?>

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php require_once '../../components/topbar.php'; ?>

    <!-- Start of Sidebar -->
    <?php include_once '../../components/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid p-4">

          <!-- FAQ heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Frequently Asked Questions</h1>
          </div>

          <?php
            $dao = new Dao('Dummy_TA_Ticketing');
            $FAQs = $dao->getFAQs();
            if (isset($FAQs)) {
                for ($i = 0; $i < count($FAQs); $i++) {
          ?>
                <!-- Step 1 - Submit Button -->
                <div class="mb-4">
                  <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2 mb-4">
                            <div
                              class="h5 font-weight-bold text-primary text-uppercase mb-1"
                            >FAQ #<?php echo ($i + 1); ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                              <?php echo htmlentities($FAQs[$i]['question']); ?>
                            </div>
                          </div>
                        </div>
                        <p><?php echo htmlentities($FAQs[$i]['answer']); ?></p>
                    </div>
                  </div>
                </div>
          <?php
                }
            } else {
              echo '<div class="d-sm-flex align-items-center justify-content-between mb-4">
                      <h1 class="h3 mb-0 text-gray-800">Sorry! There are no FAQs at this time!</h1>
                    </div>';
            }
          ?>

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
