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
     * Returns the onyx node number from the hostname.
     * 
     * @return $nodeNumber - The node number from the IP address hostname.
     */
    function getNodeNumber() {
        $logger = getServerLogger();
        $hostname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
        $logger->logInfo(basename(__FILE__) . ": get host name: " . $_SERVER["REMOTE_HOST"]);
        // Search for onyx node
        preg_match("/(onyx|onyxnode)(\d+)\.boisestate\.edu/", $hostname, $matches);
        if (!empty($matches) && isset($matches[2])) {
            return "Node " . $matches[2];
        } else {
            $logger->logInfo(basename(__FILE__) . ": Host is not a lab machine: " . $hostname);
        }

        // Search for os type
        $operatingSystem = NULL;
        preg_match("/(linux)|(macintosh)|(windows)|(mobile)/i", $_SERVER["HTTP_USER_AGENT"], $matches);
        $operatingSystem = !empty($matches) ? $matches[0] : "";
        return "Personal: " . $operatingSystem;
    }

    /**
     * Returns the computer name from the hostname.
     * 
     * @param $localIP - The local ip address of the user.
     * @return $computerName - The node name or the personal computer name
     */
    function getComputerName($localIP) {
        session_start();

        $logger = getServerLogger();
        $hostname = gethostbyaddr($_SERVER["REMOTE_ADDR"]);

        // If the user is on an onyx machine
        preg_match("/(onyx|onyxnode)(\d+)\.boisestate\.edu/", $hostname, $matches);
        $logger->logDebug(basename(__FILE__) . ": local IP: " . $localIP);

        if (!empty($matches) && $localIP != "") {
            $logger->logDebug(basename(__FILE__) . ": Boise State computer found");
            for ($i = 1; $i < 1000; $i++) {
                $nodeName = "onyxnode";
                if ($i < 10) {
                    $nodeName .= "0" . $i;
                } else {
                    $nodeName .= $i;
                }
                $nodeName .= ".boisestate.edu";
                if (gethostbyname($nodeName) == $localIP) {
                    return "Node " . $i;
                } else {
                    $logger->logDebug(basename(__FILE__) . ": " . gethostbyname($nodeName) . " != " . $localIP);
                }
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