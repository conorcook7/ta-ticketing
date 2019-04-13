<?php

/**
 * Generates a url with the current protocol and host. It then appends
 * the given $path and returns the combined url.
 * 
 * This method is necessary to dynamically generate the URL for online
 * and offline services.
 * 
 * @param $path - The path to append to the hostname
 * @return $combinedPath - The generated url with combined $path.
 */
function generateUrl($path) {
    // Generate host
    $host = $_SERVER["HTTP_HOST"];

    // Generate protocol
    if ($host == "taticketing.boisestate.edu") {
        $protocol = "https://";
    } else {
        $protocol = "http://";
    }

    // Combine path
    $combinedPath = $protocol . $host;
    if ($path[0] == "/") {
        $combinedPath .= $path;
    } else {
        $combinedPath .= "/" . $path;
    }
    
    return $combinedPath;
}

/**
 * Returns the logger object for the server.
 * 
 * @return $logger - The logger object for the server.
 */
function getServerLogger() {
    require_once "KLogger.php";
    $logger = new KLogger("/var/log/taticketing/",KLogger::DEBUG);
    return $logger;
}

/**
 * Returns the computer name from the hostname.
 * 
 * @param $localIP - The local ip address of the user.
 * @return $computerName - The node name or the personal computer name
 */
function getComputerName($localIP) {
    session_start();
    require_once "dao.php";

    $dao = new Dao();
    $logger = getServerLogger();
    $hostname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);

    // If the user is on an onyx machine
    preg_match("/(onyx|onyxnode)(\d+)\.boisestate\.edu/", $hostname, $matches);
    $logger->logDebug(basename(__FILE__) . ": local IP: " . $localIP);
    // 
    if (!empty($matches) && $localIP != "") {
        $logger->logDebug(basename(__FILE__) . ": Boise State computer found");
        $bugReportCreated = FALSE;
        for ($i = 1; $i < 1000; $i++) {
            $nodeName = "onyxnode";
            if ($i < 10) {
                $nodeName .= "0" . $i;
            } else {
                $nodeName .= $i;
            }
            $nodeName .= ".boisestate.edu";
            $onyxIP = gethostbyname($nodeName);
            preg_match("/\d+\.\d+\.(\d+)/", $onyxIP, $matches);
            if (!empty($matches) && intval($matches[1]) != $i && !$bugReportCreated) {
                $errorDescription = $nodeName . "is not equal to IP address {" . $onyxIP . "}";
                $logger->logError(basename(__FILE__) . ": " . $errorDescription);
            }
            if ($onyxIP == $localIP) {
                return "Node " . $i;
            }
        }
        try {
            $logger->logError(basename(__FILE__) . ": Unable to find IP address {" . $localIP . "} in the first 1000 onyx nodes");
            $dao->createBugReport(1, "Unable to find onyx node",
                "Searched first 1000 nodes by hostname like {onyxnode00.boisestate.edu}");
        } catch (Exception $e) {
            $logger->logError(basename(__FILE__) . ": Unable to create bug report");
            $logger->logError(basename(__FILE__) . ": " . $e->getMessage());
        }
    } else {
        $logger->logInfo(basename(__FILE__) . ": Host is not a lab machine: " . $hostname);
    }

    // Search for os type
    $logger->logDebug("Not a Boise State computer");
    $operatingSystem = NULL;
    preg_match("/(linux)|(macintosh)|(windows)|(mobile)/i", $_SERVER["HTTP_USER_AGENT"], $matches);
    $operatingSystem = !empty($matches) ? $matches[0] : "";
    return "Personal: " . $operatingSystem;
}

/**
 * Update the user's permission in the session variable
 * 
 * @param $userId - The user id to get the permissions for.
 */
function updateSession($userId) {
    session_start();
    require_once "dao.php";
    $dao = new Dao();
    $user = $dao->getUserById($userId);
    if (isset($user["permission_name"])) {
        $_SESSION["user"]["permission"] = $user["permission_name"];
    }
    if (isset($user["permission_id"])) {
        $_SESSION["user"]["access_level"] = $user["permission_id"];
    }
}

/**
 * Checks for a boisestate email address
 * 
 * @param $email - The email address to search
 * @return Returns TRUE if the email address is a Boise State University email address, else FALSE.
 */
function validateBoiseStateEmail($email) {
    preg_match(
        "/\w+@(u\.|)boisestate.edu/",
        $email,
        $matches
    );
    if (!empty($matches)) {
        return TRUE;
    }
    return FALSE;
}