<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    require_once "server-functions.php";
?>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo generateUrl('/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo generateUrl('/vendor/jquery-easing/jquery.easing.min.js');?>"></script>

  <!-- Popper.js Core-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo generateUrl('/js/ajax/client-update.js');?>"></script>
  <script src="<?php echo generateUrl('/js/sb-admin-2.min.js');?>"></script>

  <!-- Page level plugins -->
  <script src="<?php echo generateUrl('/vendor/chart.js/Chart.min.js');?>"></script>

  <!-- Page level custom scripts -->
  <script src="<?php echo generateUrl('/js/ajax/tables-ajax.js');?>"></script>
</body>
</html>
