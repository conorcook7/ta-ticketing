<?php

    /**
     * Generates a url with the current protocol and host. It then appends
     * the given $path and returns the combined url.
     * 
     * @param $path - The path to append to the hostname
     * @return $combinedPath - The generated url with combined $path.
     */
    function generateUrl($path) {
        // Generate protocol
        $protocol = strtolower($_SERVER["SERVER_PROTOCOL"]);
        $protocol = explode("/", $protocol);
        $protocol = $protocol[0];

        // Generate host
        $host = $_SERVER["HTTP_HOST"];

        // Combine path
        $combinedPath = $protocol . "://" . $host;
        if ($path[0] == "/") {
            $combinedPath .= $path;
        } else {
            $combinedPath .= "/" . $path;
        }
        
        return $combinedPath;
    }