<!-- Teaching Assistant Pages -->
<li class="nav-item <?php if ($page == 'my-open-tickets.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=my-tickets');?>">
        <i class="fas fa-fw fa-ticket-alt"></i>
        <span>My Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=open-tickets');?>">
        <i class="fas fa-fw fa-list-ul"></i>
        <span>All Open Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=closed-tickets');?>">
        <i class="fas fa-fw fa-tasks"></i>
        <span>Closed Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=create-ticket');?>">
        <i class="fas fa-fw fa-plus-square"></i>
        <span>Create A Ticket</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=all-tickets');?>">
        <i class="fas fa-fw fa-list-alt"></i>
        <span>All Tickets</span>
    </a>
</li>
<!-- End Teaching Assistant Pages -->