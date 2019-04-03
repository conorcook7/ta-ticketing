<?php
    session_start();
?>

<!-- Help Page -->
<li class="nav-item <?php if ($nav == 'help') { echo 'active'; } ?>">
    <a
        class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseHelpPages"
        aria-expanded="true"
        aria-controls="collapseHelpPages"
    >
        <i class="fas fa-fw fa-question"></i>
        <span class="LetterSpacing">Help</span>
    </a>
    <div id="collapseHelpPages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
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
        </div>
    </div>
</li>
