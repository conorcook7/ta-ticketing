<!-- professor Pages-->
<!-- View Users Navbar Item -->
<li class="nav-item <?php if ($page == 'users-table.php' || $page == 'professor.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=users');?>">
        <i class="fas fa-fw fa-users"></i>
        <span class="LetterSpacing">View Users</span>
    </a>
</li>

<!-- View Online Users Navbar Item -->
<li class="nav-item <?php if ($page == 'online-users-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=online-users');?>">
        <i class="fas fa-fw fa-user-check"></i>
        <span class="LetterSpacing">View Online Users</span>
    </a>
</li>

<!-- View All Tickets Navbar Item -->
<li class="nav-item <?php if ($page == 'tickets-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=tickets');?>">
        <i class="fas fa-fw fa-list-alt"></i>
        <span class="LetterSpacing">View All Tickets</span>
    </a>
</li>

<!-- View Open Tickets Navbar Item -->
<li class="nav-item <?php if ($page == 'open-tickets-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=open-tickets');?>">
        <i class="fas fa-fw fa-list-ul"></i>
        <span class="LetterSpacing">View Open Tickets</span>
    </a>
</li>

<!-- View Closed Tickets Navbar Item -->
<li class="nav-item <?php if ($page == 'closed-tickets-table.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=closed-tickets');?>">
        <i class="fas fa-fw fa-tasks"></i>
        <span class="LetterSpacing">View Closed Tickets</span>
    </a>
</li>

<!-- Blacklist Navbar Item -->
<li class="nav-item <?php if ($page == 'blacklist.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=blacklist');?>">
        <i class="fas fa-fw fa-ban"></i>
        <span class="LetterSpacing">View Email Blacklist</span>
    </a>
</li>

<!-- View Bug Reports Navbar Item -->
<li class="nav-item <?php if ($nav == 'professor' && $page == 'bug-reports.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=bug-reports');?>">
        <i class="fas fa-fw fa-bug"></i>
        <span class="LetterSpacing">View Bug Reports</span>
    </a>
</li>

<!-- Create/Delete Classes Navbar Item -->
<li class="nav-item <?php if ($page == 'classes.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=classes');?>">
        <i class="fas fa-fw fa-chalkboard-teacher"></i>
        <span class="LetterSpacing">Create/Delete Classes</span>
    </a>
</li>

<!-- Update/Create User Navbar Item -->
<li class="nav-item <?php if ($page == 'update-users.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=users-form');?>">
        <i class="fas fa-fw fa-user-cog"></i>
        <span class="LetterSpacing">Update/Create User</span>
    </a>
</li>

<!-- Create/Delete Navbar Item -->
<li class="nav-item <?php if ($nav == 'professor' && $page == 'faq.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/professor.php?page=faq');?>">
        <i class="fas fa-fw fa-question-circle"></i>
        <span class="LetterSpacing">Create/Delete FAQs</span>
    </a>
</li>
<!-- End professor Pages -->