<?php 
    session_start();

    require_once "server-functions.php";
    require_once "dao.php";

    $dao = new Dao();
    if (!isset($_SESSION["user"]) ||
    $dao->getOnlineStatus($_SESSION["user"]["email"]) == "OFFLINE") {
        header("Location: " . generateUrl("/handlers/logout-handler.php"));
        exit();
    }

    if (strtoupper($_SESSION["user"]["permission"]) == "DENIED") {
        header("Location: ". generateUrl("/pages/403.php"));
        exit();
    }
    
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>
    <?php
        if ($page == 'admin.php'){
            echo "Admin - Dashboard";
        }elseif($page == 'ta.php'){
            echo "TA - Dashboard";
        }elseif($page == 'user.php'){
            echo "Student - Dashboard";
        }elseif($page == 'about.php' || $nav == 'about'){
            echo "About Page";
        }else{
            echo "TA-Ticketing";
        }
        ?>
    
    </title>
    <!-- TA-Ticketing - Dashboard -->
  <link rel="shortcut icon" href="https://brandstandards.boisestate.edu/wp-content/themes/framewerk/framewerk/frontend/images/layout/favicon.ico">

  <!-- Custom fonts for this template-->
  <link href="<?php echo generateUrl('/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <!-- <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo generateUrl('/css/sb-admin-2.css'); ?>" rel="stylesheet">
  <!-- <link href="../css/sb-admin-2.css" rel="stylesheet"> -->


  <!-- Custom styles for this page -->
  <link href="<?php echo generateUrl('/vendor/datatables/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">
  <!-- <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
  <script src="<?php echo generateUrl('/vendor/jquery/jquery.min.js');?>"></script>
  <!-- Page level plugins -->
  <script src="<?php echo generateUrl('/vendor/datatables/jquery.dataTables.min.js');?>"></script>
  <script src="<?php echo generateUrl('/vendor/datatables/dataTables.bootstrap4.min.js');?>"></script>
  <script src="<?php echo generateUrl('/js/demo/datatables-demo.js');?>"></script>
  <script src="<?php echo generateUrl('/js/limit-input.js');?>"></script>
</head>

<body id="page-top">
