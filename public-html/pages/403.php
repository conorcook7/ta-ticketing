<?php
    session_start();
    require_once "../components/server-functions.php";
    require_once "../components/header.php";

    $page = "403.php";
    $nav = "403";
?>

<!-- Page Wrapper -->
<div id="wrapper" class="h-100">

    <?php require_once "../components/sidebar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column h-100">

        <?php require_once "../components/topbar.php"; ?>

        <!-- 403 Error Text -->
        <div class="d-flex flex-column justify-content-center text-center p-4 h-100">
            <div class="error mx-auto" data-text="403">403</div>
            <p class="lead text-gray-800 mb-5">Permission Denied</p>
            <a href="<?php echo generateUrl('/pages/') . strtolower($_SESSION['user']['permission']) . '.php'; ?>">&larr; Back to Dashboard</a>
        </div>

        <?php include_once '../components/footer.php' ?>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php require_once "../components/scripts.php"; ?>
