<?php

    /**
     * Generates a url with the current protocol and host. It then appends
     * the given $path and returns the combined url.
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
        $combinedPath = $protocol . "://" . $host;
        if ($path[0] == "/") {
            $combinedPath .= $path;
        } else {
            $combinedPath .= "/" . $path;
        }
        
        return $combinedPath;
    }