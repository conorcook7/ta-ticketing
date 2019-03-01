<?php
    require_once __DIR__ . "/config.php";

    $loginUrl = $client->createAuthUrl();

    if (isset($_SESSION["access_token"])) {
        $client->setAccessToken($_SESSION["access_token"]);

    } else if (isset($_GET["code"])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);
        $_SESSION["access_token"] = $token;

    } else {
        header("Location: " . $loginUrl);
        exit();
    }

    // Store user data in the session.
    $google_oauth = new Google_Service_Oauth2($client);
    $userData = $google_oauth->userinfo_v2_me->get();
    $_SESSION['user']['id'] = $userData['id'];
    $_SESSION['user']['email'] = $userData['email'];
    $_SESSION['user']['familyName'] = $userData['familyName'];
    $_SESSION['user']['givenName'] = $userData['givenName'];
    $_SESSION['user']['picture'] = $userData['picture'];
    $_SESSION['user']['gender'] = $userData['gender'];

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <link href="css/signin.css" rel="stylesheet">

    <title>Sign-in</title>
  </head>
   <body class="text-center" style="background-image: url(../img/bsu_canvas.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <form class="form-signin form-containter" action="">
                            <img class="mb-4 image" src="https://www.cludo.com/wp-content/uploads/2018/10/Boise-State-University-Logo.png" alt="" width="300" height="194">
                             <h1 id="please-sign" class="h3 mb-3 font-weight-normal">Please sign in</h1>
                            <div class="form-group">
                                <a href="<?php echo $loginUrl ?>">Google Login Link</a>
                                <button onclick="window.location = '<?php echo $loginUrl ?>';" class="btn btn-lg btn-primary btn-block" type="button"><i class="fas fa-sign-in-alt"></i>Google Sign In</button>
                            </div>
                             <p id="please-sign" class="mt-5 mb-3">&copy; Boise State University 2019</p>
                         </form>
                        <?php
                            // Store user data in the session.
                            // $google_oauth = new Google_Service_Oauth2($client);
                            // $userData = $google_oauth->userinfo_v2_me->get();
                            // $_SESSION['user']['id'] = $userData['id'];
                            // $_SESSION['user']['email'] = $userData['email'];
                            // $_SESSION['user']['familyName'] = $userData['familyName'];
                            // $_SESSION['user']['givenName'] = $userData['givenName'];
                            // $_SESSION['user']['picture'] = $userData['picture'];
                            // $_SESSION['user']['gender'] = $userData['gender'];

                            echo "<pre>" . print_r($_SESSION, 1) . "</pre>";
                        ?>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
  </body>
</html>