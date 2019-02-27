<?php require_once '../components/header.php'; ?>

<body id="page-top">

  <div id="wrapper">
  
    <!-- Start of Sidebar -->
    <?php include_once '../components/sidebar.php'; ?>
    <!-- End of Sidebar -->
    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">



        <!-- Topbar -->
        <?php include_once '../components/topbar.php'; ?>
        <!-- End of Topbar -->
        
        <table class="table">
          <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Permission Level</th>
            <th scope="col">User ID</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td>test</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

<?php require_once '../components/footer.php'; ?>
</html>
