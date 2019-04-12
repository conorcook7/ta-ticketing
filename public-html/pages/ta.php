<?php
    session_start();
    $nav = 'ta';
    $page = 'ta.php';
      
      if($_SESSION['user']['access_level'] >= 2){
        if(isset($_GET['page'])){
          $_SESSION['ta-selection'] = $_GET['page'];
          $selection = $_SESSION['ta-selection'];
            if ($selection == 'DEFAULT' || $selection == 'ta'){
                $page = 'ta.php';
            } else if ($selection == 'my-tickets'){
                $page = 'my-ta-tickets.php';
            } else if ($selection == 'all-tickets'){
                $page = 'tickets-table.php';
            } else if ($selection == 'open-tickets'){
              $page = 'open-tickets-table.php';
            } else if ($selection == 'closed-tickets'){
              $page = 'closed-tickets-table.php';
            } else if ($selection == 'create-ticket'){
              header('Location: userform.php');
              exit();
            }
        } else {
          $_SESSION['ta-selection'] = 'DEFAULT';
        }
      } else {
        $_SESSION['ta-selection'] = 'UNNAUTHORIZED';
        header("Location: 403.php");
        exit();
      }
    
      require_once "../components/header.php";
      require_once "../components/dao.php";
      require_once "../components/server-functions.php";
    
      try{
        $dao = new Dao();
        $users = $dao->getUsers();
    
      }catch(Exception $e) {
        $logger = getServerLogger();
        $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
        exit(0);
      }
    ?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php';?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="h-100">

            <!-- Topbar -->
            <?php include_once '../components/topbar.php'; ?>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid h-100">
                <?php if (isset($_SESSION["success"])){ ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?php echo $_SESSION["success"]; ?>
                </div>
                <?php } elseif (isset($_SESSION["failure"])) { ?>
                <div class="alert alert-danger">
                    <strong>Failure!</strong> <?php echo $_SESSION["failure"]; ?>
                </div>
                <?php }
                    unset($_SESSION["failure"]);
                    unset($_SESSION["success"]);
                    ?>

                <div id="ta-close" class="p-4 mb-4" style="display: none">
                  <form method="POST" id="ta-close-form" action="../handlers/ticket-handler.php">
                    <input id="my-open-ticket-id" type="hidden" name="my_open_ticket_id" value="" />
                    <input id="my-closer-user-id" type="hidden" name="my_closer_user_id" value="" />
                    <label for="closing_description">Ticket Closing Description</label>
                    <textarea
                      class="form-control py-2 w-50"
                      id="closing-description"
                      name="my_closing_description"
                      rows=4
                      maxlength=500
                      required="true"
                      placeholder="Please describe how you helped with this ticket..."></textarea>
                    <div class="text-right w-50">
                      <span id="char-count">0</span>
                      <span>/</span>
                      <span id="max-char-count">500</span>
                    </div>
                    <div class="d-flex justify-content-start w-50">
                      <button type="submit" class="btn btn-danger">Finish Closing</button>
                    </div>
                  </form>
                </div>


                <?php
                    $selection = $_SESSION['ta-selection'];
                    if ($selection == 'UNNAUTHORIZED'){ ?>
                <div class="d-flex flex-column justify-content-center text-center p-4 h-100">
                    <div class="error mx-auto" data-text="403">403</div>
                    <p class="lead text-gray-800 mb-5">Permission Denied</p>
                    <a href="<?php echo generateUrl('/pages/') . strtolower($_SESSION['user']['permission']) . '.php'; ?>">&larr; Back to Dashboard</a>
                </div>
                <?php
                    } elseif ($selection == 'DEFAULT' || $selection == 'ta' || $selection == 'my-tickets'){
                      include_once '../components/tickets/my-ta-tickets.php';
                    } elseif ($selection == 'all-tickets'){
                      include_once '../components/tickets/tickets-table.php';
                    } elseif ($selection == 'open-tickets'){
                      include_once '../components/tickets/open-tickets-table.php';
                    } elseif ($selection == 'closed-tickets'){
                      include_once '../components/tickets/closed-tickets-table.php';
                    }
                    ?>
            </div>
            <!-- End Page Content -->

            <!-- Footer -->
            <?php include_once '../components/footer.php' ?>
            
        </div>
        <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<!-- Scripts -->
<script src="../js/ta.js"></script>
<?php 
    require_once '../components/logout-modal.php';
    require_once '../components/scripts.php' 
    ?>