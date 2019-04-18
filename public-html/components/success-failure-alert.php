<?php
    // Start the session
    session_start();

    // Check if an alert should be printed
    if (isset($_SESSION["success"])) {
?>
        <div class='alert alert-success mx-4'>
            <strong>Success!</strong>
            <?php echo $_SESSION["success"]; ?>
        </div>
<?php
    } else if (isset($_SESSION["failure"])) {
?>
        <div class='alert alert-danger mx-4'>
            <strong>Failure!</strong>
            <?php echo $_SESSION["failure"]; ?>
        </div>
<?php
    }

    // Unset the messages
    unset($_SESSION["failure"]);
    unset($_SESSION["success"]);
?>