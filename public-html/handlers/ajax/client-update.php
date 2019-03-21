<?php
    session_start();

    require_once "../components/dao.php";
    require_once "../components/KLogger.php";
    require_once "../components/server-functions.php";

    // Tolerance for check in with units of seconds
    $checkInTolerance = 15 * 60;

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
    isset($_POST['unload'])) {

        if (isset($_SESSION["user"]["online_since"])) {

            // Get database connection for updates
            $dao = new Dao();
            
            // Check for the time tolerance to check in
            $now = new DateTime("now", new DateTimeZone("America/Boise"));
            $onlineSince = $_SESSION["user"]["online_since"];
            $time = $now->getTimestamp() - $onlineSince->getTimestamp();
            $data = Array();

            // If check-in is within tolerance
            if ($time <= $checkInTolerance) {

                // Set return data
                $data["reset"] = TRUE;

                // Update session
                $_SESSION["user"]["online_since"] = new DateTime(
                    "now", new DateTimeZone("America/Boise"));

                try {
                    $count = 0;

                    // If the check-in is an unload
                    if ($_POST["unload"] === "true") {
                        $status = $dao->setUserAway($_SESSION["user"]["email"]);
                        if (!$status) {
                            $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
                            $logger->logError(__FILE__ . ": Unable to set user away");
                        }
                        $_SESSION["user"]["online"] = "AWAY";

                    // If the check-in is an interval check-in
                    } else if ($_POST["unload"] === "false") {
                        $status = $dao->setUserOnline($_SESSION["user"]["email"]);
                        if (!$status) {
                            $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
                            $logger->logError(__FILE__ . ": Unable to set user online");
                        }
                        $_SESSION["user"]["online"] = "ONLINE";
                    }
                } catch (Exception $e) {
                    $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
                    $logger->logError(__FUNCTION__ . ": " . $e->getMessage());
                }
            
            // If check-in was not within tolerance
            } else {
                $data["reset"] = FALSE;
                $data["redirect"] = generateUrl("/handlers/logout-handler.php");
            }

            // Unset post
            unset($_POST);

            // Return the data
            header("Content-Type: application/json");
            echo json_encode($data);
            exit();
        }
    }