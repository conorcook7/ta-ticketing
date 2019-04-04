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
        
        // Search for onyx node
        preg_match("/.*onyxnode(\d+)\.boisestate\.edu.*/", $hostname, $matches);
        if (!empty($matches) && isset($matches[1])) {
            return "Node " . $matches[1];
        }

        // Search for os type
        $operatingSystem = NULL;
        preg_match("/(linux)|(macintosh)|(windows)|(mobile)/i", $_SERVER["HTTP_USER_AGENT"], $matches);
        $operatingSystem = !empty($matches) ? $matches[0] : "";

        // Check that hostname is an IP address
        preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}/", $hostname, $matches);
        if (!empty($matches)) {
            return "Personal: " . $operatingSystem;
        }

        return "Personal: " . $operatingSystem . ": ". $hostname;
    }