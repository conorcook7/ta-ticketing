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