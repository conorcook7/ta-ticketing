<?php
    session_start();
    require_once "../components/server-functions.php";
    require_once "../components/header.php";
    
    $page = "404.php";
    $nav = "404";
    ?>
<!-- Page Wrapper -->
<div id="wrapper" class="h-100">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column h-100">
        <?php require_once "../components/topbar.php"; ?>
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
        <!-- 404 Error Text -->
        <div class="d-flex flex-column justify-content-center text-center p-4 h-100">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <p class="text-gray-800">Sorry we could not figure that one out!</p>
            <a href="<?php echo generateUrl('/pages/') . strtolower($_SESSION['user']['permission']) . '.php'; ?>">&larr; Back to Dashboard</a>
        </div>
        <?php include_once '../components/footer.php' ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<?php require_once "../components/scripts.php"; ?>