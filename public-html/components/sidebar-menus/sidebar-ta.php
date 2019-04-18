<?php
/**
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */
?>
<!-- Teaching Assistant Pages -->
<li class="nav-item <?php if ($page == 'my-ta-tickets.php' || $page == 'ta.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=my-tickets');?>">
        <i class="fas fa-fw fa-ticket-alt"></i>
        <span class="LetterSpacing">My Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'open-tickets-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=open-tickets');?>">
        <i class="fas fa-fw fa-list-ul"></i>
        <span class="LetterSpacing">All Open Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'closed-tickets-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=closed-tickets');?>">
        <i class="fas fa-fw fa-tasks"></i>
        <span class="LetterSpacing">Closed Tickets</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'userform.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=create-ticket');?>">
        <i class="fas fa-fw fa-plus-square"></i>
        <span class="LetterSpacing">Create A Ticket</span>
    </a>
</li>

<li class="nav-item <?php if ($page == 'tickets-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/ta.php?page=all-tickets');?>">
        <i class="fas fa-fw fa-list-alt"></i>
        <span class="LetterSpacing">All Tickets</span>
    </a>
</li>
<!-- End Teaching Assistant Pages -->