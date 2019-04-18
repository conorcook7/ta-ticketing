<?php
    session_start();
    require_once "../components/server-functions.php";
    require_once "../components/header.php";
    
    $page = "403.php";
    $nav = "403";
    
    $logger = getServerLogger();
    $logger->logWarn(basename(__FILE__) . ": User access forbidden for user: " . $_SESSION["user"]["user_id"]);
    $logger->logWarn(basename(__FILE__) . ": User attempted to access from " . gethostbyaddr($_SERVER["REMOTE_ADDR"]) . " at " . $_SERVER["REMOTE_ADDR"]);
    ?>
<!-- Page Wrapper -->
<div id="wrapper" class="h-100">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column h-100">
        <?php
            require_once "../components/topbar.php";
            require_once "../components/success-failure-alert.php";
        ?>
        <!-- 403 Error Text -->
        <div class="d-flex flex-column justify-content-center text-center p-4 h-100">
            <div class="error mx-auto" data-text="403">403</div>
            <p class="lead text-gray-800 mb-5">Permission Denied</p>
            <p class="text-gray-800">
                If you are supposed to be able to reach this page, try contacting
                <a href="mailto: BenjaminPeterson@boisestate.edu">Benjamin Peterson</a>.
            </p>
            <a href="<?php echo generateUrl('/pages/') . strtolower($_SESSION['user']['permission']) . '.php'; ?>">&larr; Back to Dashboard</a>
        </div>
        <?php include_once '../components/footer.php' ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<?php require_once "../components/scripts.php"; ?>