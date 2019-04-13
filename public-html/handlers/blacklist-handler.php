<?php

require_once "../components/dao.php";
$dao = new Dao();

// Delete blacklist entry
if (isset($_POST["blacklistId"]) && !isset($_POST["blacklistEmailUpdate"]) && !isset($_POST["blacklistEmail"])) {
    $deleted = $dao->deleteBlacklistEntryById($_POST["blacklistId"]);
    if ($deleted) {
        $_SESSION["blacklist-success"] = "Email was removed from the blacklist.";
    } else {
        $_SESSION["blacklist-failure"] = "Unable to remove email from the blacklist.";
    }

// Add a blacklist entry
} else if (isset($_POST["blacklistEmail"])) {
    $created = $dao->createBlacklistEntry($_POST["blacklistEmail"]);
    if ($created) {
        $_SESSION["blacklist-success"] = "Email was added to the blacklist.";
    } else {
        $_SESSION["blacklist-failure"] = "Unable to add email to the blacklist.";
    }

// Update an email in the blacklist
} else if (isset($_POST["blacklistId"]) && isset($_POST["blacklistEmailUpdate"])) {
    $updated = $dao->updateBlacklistEntry($_POST["blacklistId"], $_POST["blacklistEmailUpdate"]);
    if ($deleted) {
        $_SESSION["blacklist-success"] = "Email was updated in the blacklist.";
    } else {
        $_SESSION["blacklist-failure"] = "Unable to update email in the blacklist.";
    }
}

// Redirect back to the blacklist
header("Location: ../pages/admin.php?id=blacklist");
exit();