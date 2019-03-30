<!-- Teaching Assistant Pages -->
<li class="nav-item <?php if ($page == 'my-open-tickets.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?id=mytickets');?>">
        <i class="fas fa-fw fa-question"></i>
        <span>My Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>All Open Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=users');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Closed Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/admin.php?id=users');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Create A Ticket</span>
    </a>
</li>
<!-- End Teaching Assistant Pages -->