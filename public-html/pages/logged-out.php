<?php
  require_once "../components/server-functions.php";

  session_start();

  $page = 'logged-out.php';
  $nav = 'pages';
  
  if (isset($_SESSION["user"]["permission"])) {
      header("Location: " . generateUrl("/pages/" . strtolower($_SESSION["user"]["permission"]) . ".php"));
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Logged Out - TA Ticketing</title>

        <!-- Custom fonts for this template-->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../css/sb-admin-2.min.css" rel="stylesheet">
        <link href="../css/logged-out.css" rel="stylesheet">

        <!-- Scripts for this page -->
        <script src="<?php echo generateUrl('/vendor/jquery/jquery.min.js');?>"></script>
    </head>
    <body id="page-top">
        <!-- Logged Out Text -->
        <div class="flex-column d-flex text-center align-items-center justify-content-center h-100">
        <?php
            if (isset($_SESSION["login-error"])) {
                echo "<div class='alert alert-danger'>" . $_SESSION["login-error"] . "</div>";
                unset($_SESSION["login-error"]);
            }
        ?>
        <div class="h1 mx-auto my-5">You are signed out.</div>
        <p class="text-gray mb-0">Please use your Boise State email address to continue.</p>
        <form class="my-4" action="../auth/google-auth/google.php">
            <button id="google-card" class="card p-3 m-auto text-center" type="submit">
            <span><img id="google-logo" src="../img/google-logo-transparent.png" alt="google-logo"/><span>
            <span class="pl-2">Sign in with Google</span>
            </button>
        <!-- Footer -->
        <?php include_once '../components/footer.php' ?>
        <!-- End of Footer -->
        </div>
     
        <script>
            var $mytimeout;
            if ( window.RTCPeerConnection  window.mozRTCPeerConnection  window.webkitRTCPeerConnection ) {
                $mytimeout = setTimeout(function(){
                    console.log('Local ip not supported');
                },3000);
                window.RTCPeerConnection = window.RTCPeerConnection  window.mozRTCPeerConnection  window.webkitRTCPeerConnection;
                var $pc = new RTCPeerConnection({iceServers:[]}), $noop = function(){};
                $pc.createDataChannel("");
                $pc.createOffer($pc.setLocalDescription.bind($pc), $noop);
                $pc.onicecandidate = function($ice) {
                    clearTimeout($mytimeout);
                    if(!$ice  !$ice.candidate  !$ice.candidate.candidate) {
                        console.log('No ice');
                    } else {
                        $ip = /([0-9]{1,3}(.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/.exec($ice.candidate.candidate)[1];
                        $pc.onicecandidate = $noop;
                        console.log($ip);
                    };
                } else {
                    console.log("Local IP address is not supported in this browser");
                }
            } else {
                console.log('No local IP');
            }
        </script>
<?php
  require_once "../components/scripts.php";
?>
