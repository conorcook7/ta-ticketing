<?php
    session_start();
    $page = "how-to.php";
    $nav = "help";
    require_once "../../components/header.php";
    ?>
<div id="wrapper">
    <?php include_once '../../components/sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <?php include_once '../../components/topbar.php'; ?>
        
        <!-- Main Content -->
        <div id="content" class="px-2">

            <!-- Begin Page Content -->
            <div class="container-fluid p-4">
                <div class="row mb-2 border-bottom">
                    <div class="h2 text-gray-800">How-To</div>
                </div>
                <?php
                    $permission = strtoupper($_SESSION["user"]["permission"]);
                    
                    if ($permission == "ADMIN" || $permission == "PROFESSOR") {
                    ?>
                <div class="row">
                    <div class="col-xs-12">
                        <nav class="mb-4">
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a
                                    class="nav-item nav-link active"
                                    id="nav-how-to-admin-tab"
                                    data-toggle="tab"
                                    href="#nav-how-to-admin"
                                    role="tab"
                                    aria-controls="nav-how-to-admin"
                                    aria-selected="true"
                                    >Admin</a>
                                <a
                                    class="nav-item nav-link"
                                    id="nav-how-to-ta-tab"
                                    data-toggle="tab"
                                    href="#nav-how-to-ta"
                                    role="tab"
                                    aria-controls="nav-how-to-ta"
                                    aria-selected="false"
                                    >Teaching Assistant</a>
                                <a
                                    class="nav-item nav-link"
                                    id="nav-how-to-user-tab"
                                    data-toggle="tab"
                                    href="#nav-how-to-user"
                                    role="tab"
                                    aria-controls="nav-how-to-user"
                                    aria-selected="false"
                                    >User</a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            <?php require_once "how-to/how-to-admin.php"; ?>
                            <?php require_once "how-to/how-to-ta.php"; ?>
                            <?php require_once "how-to/how-to-user.php"; ?>
                        </div>
                    </div>
                </div>
                <?php  } else if ($permission == "TA") { ?>
                <div class="row">
                    <div class="col-xs-12">
                        <nav class="mb-4">
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a
                                    class="nav-item nav-link active"
                                    id="nav-how-to-ta-tab"
                                    data-toggle="tab"
                                    href="#nav-how-to-ta"
                                    role="tab"
                                    aria-controls="nav-how-to-ta"
                                    aria-selected="false"
                                    >Teaching Assistant</a>
                                <a
                                    class="nav-item nav-link"
                                    id="nav-how-to-user-tab"
                                    data-toggle="tab"
                                    href="#nav-how-to-user"
                                    role="tab"
                                    aria-controls="nav-how-to-user"
                                    aria-selected="false"
                                    >User</a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            <?php require_once "how-to/how-to-ta.php"; ?>
                            <?php require_once "how-to/how-to-user.php"; ?>
                        </div>
                    </div>
                </div>
                <?php   } else { require_once "how-to/how-to-user.php"; } ?>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <?php include_once '../../components/footer.php'; ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<?php require_once "../../components/scripts.php";?>