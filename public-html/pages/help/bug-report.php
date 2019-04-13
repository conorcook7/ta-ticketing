<?php
    session_start();
    
    $nav = "help";
    $page = "bug-report.php";
    
    require_once "../../components/header.php";
    require_once "../../components/dao.php";
    ?>
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Start of Sidebar -->
    <?php include_once '../../components/sidebar.php'; ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column w-100">

        <!-- Topbar -->
        <?php include_once '../../components/topbar.php'; ?>
        <!-- End of Topbar -->
      
        <!-- Main Content -->
        <div id="content">
            <div class="container-fluid px-4 h-100">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="card shadow w-50 m-4">
                        <div class="card-header">
                            <span class="h3 mb-0 text-gray-800">Report a Problem</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><i class="fas fa-exclamation-circle"></i> Reporting an issue will notify all of the website administrators via email.</p>
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
                            <form id="bug-form" method="POST" action="../../handlers/bug-report-handler.php">
                                <label for="title">Issue</label>
                                <div class="form-group w-50">
                                    <input
                                        type="text"
                                        id="title"
                                        name="title"
                                        class="form-control"
                                        placeholder="Unable to create ticket..."
                                        value="<?php echo isset($_SESSION["presets"]["title"]) ? $_SESSION["presets"]["title"] : ""; ?>"
                                        required="true"
                                        maxlength=45
                                        />
                                </div>
                                <label for="description">Description</label>
                                <div class="form-group">
                                    <textarea 
                                        id="description"
                                        name="description"
                                        class="form-control"
                                        rows=7
                                        maxlength=4000
                                        placeholder="I was unable to create a ticket because..."
                                        ><?php echo isset($_SESSION["presets"]["description"]) ? $_SESSION["presets"]["description"] : ""; ?></textarea>
                                    <div class="text-right">
                                        <span id="char-count">0</span>
                                        <span>/</span>
                                        <span id="max-char-count">1000</span>
                                    </div>
                                </div>
                                <div class="d-flex form-group justify-content-end">
                                    <button type="submit" class="btn btn-primary">Report Issue</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "../../components/footer.php"; ?>
    </div>
</div>
<script src="../../js/bug-report.js"></script>
<?php
    require_once "../../components/scripts.php";
    unset($_SESSION["presets"]);
    ?>