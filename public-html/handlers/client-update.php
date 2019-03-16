<?php
    session_start();

    require_once "../components/dao.php";
    require_once "../components/KLogger.php";
    require_once "../components/server-functions.php";

    // Tolerance for check in with units of seconds
    $checkInTolerance = 60;

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' &&
    isset($_POST['unload'])) {

        // If the user "left" the page via unloading the window
        if ($_POST["unload"] === "true") {
            $_SESSION["user"]["online"] = FALSE;

            // Delay the logout from page unload
            // $delay = microtime(TRUE);
            // do {
            //     $elapsedTime = microtime(TRUE) - $delay;
            // } while ($elapsedTime < $checkInTolerance);

            // Check if the session variable was ever set to TRUE
            if ($_SESSION["user"]["online"] === FALSE) {
                $data = [
                    "reset" => FALSE,
                    "time" => $time . " seconds",
                    "redirect" => generateUrl("/handlers/logout-handler.php"),
                ];

                // Return the data
                header("Content-Type: application/json");
                echo json_encode($data);
                exit();
            }

        // If the user sent an interval update
        } else if ($_POST["unload"] === "false") {

            if (isset($_SESSION["user"]["online_since"])) {
                
                // Check for the time tolerance to check in
                $now = new DateTime("now", new DateTimeZone("America/Boise"));
                $onlineSince = $_SESSION["user"]["online_since"];
                $time = $now->getTimestamp() - $onlineSince->getTimestamp();
                $data = Array();

                // If check-in is within tolerance
                if ($time <= $checkInTolerance) {
                    // Set return data
                    $data["reset"] = TRUE;
                    $data["time"] = $time . " seconds";

                    // Update session
                    $_SESSION["user"]["online_since"] = new DateTime(
                        "now", new DateTimeZone("America/Boise"));

                    // Update online flag in database
                    $dao = new Dao("Dummy_TA_Ticketing");
                    try {
                        $count = 0;
                        while (!$dao->setUserOnline($_SESSION["user"]["email"]) && $count < 5) {
                            $count++;
                        }
                        if ($count == 5) {
                            $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
                            $logger->logError(__FUNCTION__ . ": Unable to set user online");
                        }

                    } catch (Exception $e) {
                        $logger = new KLogger("/var/log/taticketing/", KLogger::DEBUG);
                        $logger->logError(__FUNCTION__ . ": " . $e->getMessage());
                    }
                
                // If check-in was not within tolerance
                } else {
                    $data["reset"] = FALSE;
                    $data["time"] = $time . " seconds";
                    $data["redirect"] = generateUrl("/handlers/logout-handler.php");
                }

                // Return the data
                header("Content-Type: application/json");
                echo json_encode($data);
                exit();
            }
        }
    }