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
        <?php
        echo "<tr><th>Name</th><th>Email</th><th>Permission Level</th><th>User ID</th></tr>";
        $users = $dao->getUsers();
        foreach($users as $user) {
            print   "<tr><td>" . htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']). "</td>" .
                    "<td>" . htmlspecialchars($user['email']) . "</td>" .
                    "<td>" . $user['permission_id'] . "</td>" .
                    "<td>" . $user['user_id'] . "</td></tr>";
        } ?>
      
      </div>
    </div>
  </div>
</body>

<?php require_once '../components/footer.php'; ?>
</html>