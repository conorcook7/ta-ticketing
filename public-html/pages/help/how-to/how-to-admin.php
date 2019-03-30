<?php
    session_start();
    
    if (strtoupper($_SESSION["user"]["permission"]) != "ADMIN") {
        header("Location: ../403.php");
        exit();
    }
?>

<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-how-to-admin" role="tabpanel" aria-labelledby="nav-how-to-admin-tab">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="h2 m-0 font-weight-bold text-primary">Admin How-To</h1>
            </div>
            <div class="card-body">
                <p>
                There are three easy steps that you need to follow in order to create
                a new ticket. After creation, these tickets are queued for available teaching
                assistants with the specific course you need help with. One thing to note is
                that your ticket will be taken out of the queue if you leave the site, and
                it will be placed at the end of the queue when you return to the site.
                </p>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-how-to-ta" role="tabpanel" aria-labelledby="nav-how-to-ta-tab">
        <?php require_once "how-to/how-to-ta.php"; ?>
    </div>
    <div class="tab-pane fade" id="nav-how-to-user" role="tabpanel" aria-labelledby="nav-how-to-user-tab">
        <?php require_once "how-to/how-to-user.php"; ?>
    </div>
</div>
