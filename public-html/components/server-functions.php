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
     * Returns the onyx node number from the hostname.
     * 
     * @return $nodeNumber - The node number from the IP address hostname.
     */
    function getNodeNumber() {
        $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        preg_match('/.*onyxnode(\d+)\.boisestate\.edu.*/', $hostname, $matches);
        if (!empty($matches) && isset($matches[1])) {
            return $matches[1];
        } else {
            return $hostname;
        }
    }