<?php
    session_start();
    ?>
<!-- Help Page -->
<li class="nav-item <?php echo ($nav == 'help') ? 'active' : ''; ?>">
    <a
        class="nav-link <?php echo ($nav != 'help') ? 'collapsed' : ''; ?>"
        href="#"
        data-toggle="collapse"
        data-target="#collapseHelpPages"
        aria-expanded="<?php echo ($nav == 'help') ? 'true' : 'false'; ?>"
        aria-controls="collapseHelpPages"
        >
    <i class="fas fa-fw fa-question"></i>
    <span class="LetterSpacing">Help</span>
    </a>
    <div
        id="collapseHelpPages"
        class="collapse <?php echo ($nav == 'help') ? 'show' : ''; ?>"
        aria-labelledby="headingPages"
        data-parent="#accordionSidebar"
    >
        <div class="bg-white py-2 collapse-inner rounded">
            <a
                class="collapse-item <?php if($nav == 'help' && $page == 'available-courses.php'){echo 'active';}?>"
                href="<?php echo generateUrl('/pages/help/available-courses.php');?>"
                >Available Courses</a>
            <a
                class="collapse-item <?php if($nav == 'help' && $page == 'faq.php'){echo 'active';}?>"
                href="<?php echo generateUrl('/pages/help/faq.php');?>"
                >FAQs</a>
            <a
                class="collapse-item <?php if($nav == 'help' && $page == 'how-to.php'){echo 'active';}?>"
                href="<?php echo generateUrl('/pages/help/how-to.php');?>"
                >How-To</a>
            <a
                class="collapse-item <?php if($nav == 'help' && $page == 'bug-report.php'){echo 'active';}?>"
                href="<?php echo generateUrl('/pages/help/bug-report.php');?>"
                >Report a problem</a>
        </div>
    </div>
</li>