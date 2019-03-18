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

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Logged Out Text -->
          <div class="text-center align-items-center">
            <div class="h1 mx-auto mt-5 mb-5">You are signed out.</div>
            <p class="text-gray-500 mb-0">Please sign in with your boise state email address to continue.</p>
            <a id="google-sign-in" class="m-4" href="<?php echo generateUrl("/auth/google-auth/google.php"); ?>">
                <div class="card p-3 col-lg-2 m-auto text-align-center">
                    <span class="mr-auto"><img id="google-logo" src="../img/google-logo.png" alt="google-logo"/><span>
                    <span class="pl-2">Sign in with Google</span>
                </div>
            </a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php include_once '../components/footer.php' ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

<?php
  require_once "../components/scripts.php";
?>
