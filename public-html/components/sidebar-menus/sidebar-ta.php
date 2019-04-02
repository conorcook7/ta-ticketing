<!-- Teaching Assistant Pages -->
<li class="nav-item <?php if ($page == 'my-open-tickets.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=my-tickets');?>">
        <i class="fas fa-fw fa-question"></i>
        <span>My Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=open-tickets');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>All Open Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=closed-tickets');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Closed Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=create-ticket');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>Create A Ticket</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=all-tickets');?>">
        <i class="fas fa-fw fa-users"></i>
        <span>All Tickets</span>
    </a>
</li>
<!-- End Teaching Assistant Pages -->