<?php
    session_start();

    $permission = strtoupper($_SESSION["user"]["permission"]);
    if ($permission != "TA" && $permission != "ADMIN") {
        header("Location: ../403.php");
        exit();
    }
?>

<div class="tab-pane fade <?php if ($permission == 'TA') {echo 'active show';} ?>" id="nav-how-to-ta" role="tabpanel" aria-labelledby="nav-how-to-ta-tab">
    
    <!-- Close a ticket -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Close a ticket</h1>
        </div>
        <div class="card-body">
            
        </div>
    </div>
    
    <!-- Open a ticket -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h2 m-0 font-weight-bold text-primary">Open a ticket</h1>
        </div>
        <div class="card-body">
            
        </div>
    </div>

</div>
<div class="tab-pane fade" id="nav-how-to-user" role="tabpanel" aria-labelledby="nav-how-to-user-tab">
    <?php require_once "how-to/how-to-user.php"; ?>
</div>
  