<?php
    session_start();

    if (!isset($_SESSION["access_token"])) {
        header("Location: ../auth/google-auth/login.php");
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
    <title>Made it past Google signin</title>
  </head>
   <body class="text-center" style="background-image: url(../img/bsu_canvas.jpg); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="container">
            <h1>Made it past Google Signin</h1>
            <?php echo "<pre>" . print_r($_SESSION, 1) . "</pre><br />"; ?>
        </div>
  </body>
</html>
