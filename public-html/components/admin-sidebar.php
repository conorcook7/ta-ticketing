<?php
  require_once "../server-functions.php";
?>
      <!-- Nav Item - Admin Collapse Menu -->

      <li class="nav-item <?php if($nav == 'admin'){echo 'active';}?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Admin</span>
        </a>
        <div id="collapseAdmin" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Main Page</h6>
            <a
              class="collapse-item" href="<?php echo generateUrl('/pages/admin.php';?>">Admin Page</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Tables</h6>
            <a id="users" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin.php');?>">Users</a>
            <a id="online-users" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin.php');?>">Online Users</a>
            <a id="tickets" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin.php');?>">Tickets</a>
            <a id="open-tickets" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin.php');?>">Open Tickets</a>
            <a id="closed-tickets" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin.php');?>">Closed Tickets</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Updates</h6>
            <a id="classes" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin-updates.php');?>">Classes</a>
            <a id="users-form" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin-updates.php');?>">Users</a>
            <a id="faq" class="collapse-item admin-js" href="<?php echo generateUrl('/pages/admin-updates.php');?>">FAQs</a>
            
          </div>
        </div>
      </li>