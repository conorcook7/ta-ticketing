<?php
/**
 * Copyright 2019 Boise State University
 * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
 */
?>
<!-- User Pages -->
<li class="nav-item <?php if ($page == 'user.php') { echo 'active'; }?>">
    <a class="nav-link" href="<?php echo generateUrl('/pages/user.php');?>">
        <i class="fas fa-fw fa-user"></i>
        <span class="LetterSpacing">Student Dashboard</span>
    </a>
</li>
<!-- End User Pages -->