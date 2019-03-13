<?php
    session_start();
?>

<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a
        class="sidebar-brand d-flex align-items-center justify-content-center"
        href="<?php echo $_SERVER['HTTP_HOST'] . '/pages/index.php';?>"
      >
        <div class="sidebar-brand-icon">
          <img src="<?php echo $_SERVER['HTTP_HOST'] . '/img/bsu_logo.png';?>" alt="" id="logo">
        </div>
        <div class="sidebar-brand-text mx-2">Boise State</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if($nav == 'dashboard'){echo 'active';}?>">
        <a
          class="nav-link"
          href="<?php echo $_SERVER['HTTP_HOST'] . '/pages/' .
                            strtolower($_SESSION['user']['permission']) . '.php';
                ?>"
        >
          <i class="fas fa-fw fa-home"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item - Components Collapse Menu -->
      <li class="nav-item <?php if($nav == 'components'){echo 'active';}?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a
              class="collapse-item <?php if($page == 'buttons.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/buttons.php';?>"
            >Buttons</a>
            <a
              class="collapse-item <?php if($page == 'cards.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/cards.php';?>"
            >Cards</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item <?php if($nav == 'utilities'){echo 'active';}?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a
              class="collapse-item <?php if($page == 'utilities-color.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/utilities-color.php';?>"
            >Colors</a>
            <a
              class="collapse-item <?php if($page == 'utilities-border.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/utilities-border.php';?>"
            >Borders</a>
            <a
              class="collapse-item <?php if($page == 'utilities-animation.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/utilities-animation.php';?>"
            >Animations</a>
            <a
              class="collapse-item <?php if($page == 'utilities-other.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/utilities-other.php';?>"
            >Other</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($nav == 'pages'){echo 'active';}?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a
              class="collapse-item" href="<?php echo $_SERVER['HTTP_HOST'] . '/pages/login.php';?>">Login</a>
            <a
              class="collapse-item" href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/forgot-password.php';?>">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item <?php if($page == '404.php'){echo 'active';}?>" href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/404.php';?>">404 Page</a>
            <a class="collapse-item <?php if($page == 'blank.php'){echo 'active';}?>" href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/blank.php';?>">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item <?php if($nav == 'charts.php'){echo 'active';}?>">
        <a class="nav-link" href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/charts.php';?>">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item <?php if($nav == 'tables.php'){echo 'active';}?>">
        <a class="nav-link" href="<?php echo $_SERVER['HTTP_HOST'] . '/examples/tables.php';?>">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Help Page -->
      <li class="nav-item <?php if ($nav == 'help') { echo 'active'; }?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHelpPages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-question"></i>
          <span>Help</span>
        </a>
        <div id="collapseHelpPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a 
              class="collapse-item <?php if($page == 'new-ticket.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/pages/help/new-ticket.php';?>"
            >Create a ticket</a>
            <a
              class="collapse-item <?php if($page == 'faq.php'){echo 'active';}?>"
              href="<?php echo $_SERVER['HTTP_HOST'] . '/pages/help/faq.php';?>"
            >FAQs</a>
          </div>
        </div>
      </li>

      <!-- About Page -->
      <li class="nav-item <?php if ($nav == 'about') { echo 'active'; }?>">
        <a class="nav-link" href="<?php echo $_SERVER['HTTP_HOST'] . '/pages/about.php';?>">
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