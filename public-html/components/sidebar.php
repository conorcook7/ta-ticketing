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
          <img src="<?php echo generateUrl('/img/bsu_logo.png');?>" alt="" id="logo">
        </div>
        <div class="sidebar-brand-text mx-2">Boise State</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php
        if ($nav == 'dashboard' || ($nav == 'admin' && $page == 'admin.php') ||
        ($nav == 'ta' && $page == 'ta.php') || ($nav == 'user' && $page == 'user.php')) {
            echo 'active';
        }?>"
      >
        <a
          class="nav-link"
          href="<?php echo generateUrl('/pages/') . strtolower($_SESSION['user']['permission']) . '.php';?>"
        >
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        <?php echo strtoupper($_SESSION["user"]["permission"]); ?>
      </div>

    <?php if ($_SESSION["user"]["access_level"] == 3) { ?>
      <!-- Admin Pages -->
      <li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=users');?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Users</span>
        </a>
      </li>
      <li class="nav-item <?php if ($page == 'online-users-table.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=online-users');?>">
            <i class="fas fa-fw fa-user-check"></i>
            <span>Online Users</span>
        </a>
      </li>
      <li class="nav-item <?php if ($page == 'tickets-table.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=tickets');?>">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Tickets</span>
        </a>
      </li>
      <li class="nav-item <?php if ($page == 'open-tickets-table.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=open-tickets');?>">
            <i class="fas fa-fw fa-list-ul"></i>
            <span>Open Tickets</span>
        </a>
      </li>
      <li class="nav-item <?php if ($page == 'closed-tickets-table.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=closed-tickets');?>">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Closed Tickets</span>
        </a>
      </li>
      <li class="nav-item <?php if ($page == 'classes.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=classes');?>">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Classes</span>
        </a>
      </li>
      <li class="nav-item <?php if ($page == 'update-users.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=users-form');?>">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User Updates</span>
        </a>
      </li>
      <li class="nav-item <?php if ($nav == 'admin' && $page == 'faq.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=faq');?>">
            <i class="fas fa-fw fa-question-circle"></i>
            <span>FAQs</span>
        </a>
      </li>
      <!-- End Admin Pages -->
    <?php } else if ($_SESSION["user"]["access_level"] == 2) { ?>
      <!-- Teaching Assistant Pages -->
      <li class="nav-item <?php if ($page == 'ta.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php');?>">
            <i class="fas fa-fw fa-question"></i>
            <span>TA Page Home Template</span>
        </a>
      </li>
      <!-- End Teaching Assistant Pages -->
    <?php } else if ($_SESSION["user"]["access_level"] == 1) { ?>
      <!-- User Pages -->
      <li class="nav-item <?php if ($page == 'user.php') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/user.php');?>">
            <i class="fas fa-fw fa-user"></i>
            <span>User Page Home Template</span>
        </a>
      </li>
      <!-- End User Pages -->
    <?php } else {
        header("Location: " . generateUrl("/handlers/logout-handler.php"));
        exit();
    } ?>
      <!-- Divider -->
      <hr class="sidebar-divider">

      <div class="sidebar-heading">INFO</div>

      <!-- Help Page -->
      <li class="nav-item <?php if ($nav == 'help') { echo 'active'; } ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHelpPages" aria-expanded="true" aria-controls="collapseHelpPages">
          <i class="fas fa-fw fa-question"></i>
          <span>Help</span>
        </a>
        <div id="collapseHelpPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a
              class="collapse-item <?php if($nav == 'help' && $page == 'available-courses.php'){echo 'active';}?>"
              href="<?php echo generateUrl('/pages/help/available-courses.php');?>"
            >Available courses</a>
            <a 
              class="collapse-item <?php if($nav == 'help' && $page == 'new-ticket.php'){echo 'active';}?>"
              href="<?php echo generateUrl('/pages/help/new-ticket.php');?>"
            >Create a ticket</a>
            <a
              class="collapse-item <?php if($nav == 'help' && $page == 'faq.php'){echo 'active';}?>"
              href="<?php echo generateUrl('/pages/help/faq.php');?>"
            >FAQs</a>
          </div>
        </div>
      </li>

      <!-- About Page -->
      <li class="nav-item <?php if ($nav == 'about') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo generateUrl('/pages/about.php');?>">
            <i class="fas fa-fw fa-info"></i>
            <span>About</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider"> 

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>