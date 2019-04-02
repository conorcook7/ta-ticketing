<?php
  require_once '../../components/dao.php';
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

            <!-- Topbar -->
            <?php include_once '../../components/topbar.php'; ?>
            <!-- End of Topbar -->
      
            <!-- Main Content -->
            <div id="content">

            <?php
                $dao = new Dao();
                $FAQs = $dao->getFAQs(1);
                if (count($FAQs) > 0) {
            ?>

                <!-- Begin Page Content -->
                <div class="container-fluid p-4">

                <!-- FAQ heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
                    <span class="h3 mb-0 text-gray-800">Frequently Asked Questions</span>
                    <div class="text-right">
                        <i class="fas fa-search px-2"></i>
                        <input id="faq-search" class="border-0 text-gray-800" type="textarea" style="background: inherit" placeholder="Search..." maxlength=1024/>
                    </div>
                </div>

                <?php
                        for ($i = 0; $i < count($FAQs); $i++) {
                ?>
                        <div class="faq mb-4">
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
                echo "</div>
                <!-- /.container-fluid -->";

                } else {
                    echo '
                        <div class="flex-column d-flex justify-content-center h-100">
                            <div class="h3 text-gray-800 text-center">There are no FAQs at this time.</div>
                            <div class="h3 text-gray-600 text-center">Sorry for the inconvenience!</div>
                        </div>';
                }
            ?>
        
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once '../../components/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <script src="../../js/ajax/help/help-faq.js"></script>
    <?php require_once "../../components/scripts.php"; ?>
