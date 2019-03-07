<?php 
  require_once '../components/header.php';
  require_once '../components/dao.php'; 
  $dao = new Dao("Dummy_TA_Ticketing")?>

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
          <?php 
            $users = $dao->getUsers();
            $count = 1;
            foreach($users as $user) { ?>
            <tr>
              <td><?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?></td>
              <td><?php echo htmlspecialchars($user['email']); ?></td>
              <td><?php echo $user['permission_id']; ?></td>
              <td><?php echo $user['user_id']; ?></td>
            </tr>
          <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php require_once '../components/footer.php';require_once '../components/scripts.php'; ?>

