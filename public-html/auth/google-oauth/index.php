<?php
    session_start();

    if (!isset($_SESSION["access_token"])) {
        header("Location: auth/google-oauth/login.php");
        exit();
    }
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

                        </div>
                    </div>
                </div>  
            </div>
        </div>
  </body>
</html>