<?php
    session_start();
    require_once "server-functions.php";
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?php echo generateUrl('/pages/index.php');?>"
    >
        <div class="sidebar-brand-icon">
            <img src="<?php echo generateUrl('/img/bsu_logo.png');?>" alt="" id="logo" />
        </div>
        <div class="sidebar-brand-text mx-2">Boise State</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <!-- Heading -->
    <div class="sidebar-heading LetterSpacing">
        <?php echo strtoupper($_SESSION["user"]["permission"]); ?>
    </div>

    <?php
        $permission = getPermission();
        if ($permission == "ADMIN") {
            include_once "sidebar-menus/sidebar-user.php";
            require_once "sidebar-menus/sidebar-admin.php";

        } else if ($permission == "PROFESSOR") {
            include_once "sidebar-menus/sidebar-user.php";
            require_once "sidebar-menus/sidebar-professor.php";

        } else if ($permission == "TA") {
            include_once "sidebar-menus/sidebar-user.php";
            require_once "sidebar-menus/sidebar-ta.php";

        } else if ($permission == "USER") {
            require_once "sidebar-menus/sidebar-user.php";

        } else {
            $_SESSION["login-error"] = "Unable to get your permission for the website.";
            header("Location: " . generateUrl("/handlers/logout-handler.php"));
            exit();
        }
    ?>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    <div class="sidebar-heading LetterSpacing">INFO</div>

    <!-- Courses -->
    <li class="nav-item <?php if ($nav == 'courses') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/available-courses.php');?>">
            <i class="fas fa-fw fa-school"></i>
            <span class="LetterSpacing">Courses</span>
        </a>
    </li>

    <!-- Courses -->
    <li class="nav-item <?php if ($nav == 'teaching-assistants') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/teaching-assistants.php');?>">
            <i class="fas fa-fw fa-user-friends"></i>
            <span class="LetterSpacing">Teaching Assistants</span>
        </a>
    </li>

    <!-- Help Dropdown -->
    <?php require_once "sidebar-menus/sidebar-help.php"; ?>

    <!-- About Page -->
    <li class="nav-item <?php if ($nav == 'about') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/about.php');?>">
            <i class="fas fa-fw fa-info"></i>
            <span class="LetterSpacing">About</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" /> 

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>