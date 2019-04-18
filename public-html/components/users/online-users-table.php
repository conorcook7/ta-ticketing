<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    session_start();
    $page = "online-users-table.php";
?>
<div class="container-fluid">
        <!-- All Users Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Online Users</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="center">First Name</th>
                      <th class="center">Last Name</th>
                      <th class="center">Email</th>
                      <th class="center">Permission Level</th>
                      <th class="center">User ID</th>
                      <th class="center">Update User</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                      $page = strtoupper($_SESSION["user"]["permission"]) == "ADMIN" ? "admin.php?id" : "professor.php?page";
                      $users = $dao->getOnlineUsers();
                      foreach($users as $user) { 
                  ?>
                        <tr>
                        <form method="POST" action="../pages/<?php echo $page; ?>=users-form">
                            <input type="hidden" name="firstName" value="<?php echo htmlspecialchars($user['first_name']); ?>"/>
                            <input type="hidden" name="lastName" value="<?php echo htmlspecialchars($user['last_name']); ?>"/>
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"/>
                            <input type="hidden" name="permissionID" value="<?php echo $user['permission_id']; ?>"/>
                            <input type="hidden" name="userID" value="<?php echo $user['user_id']; ?>"/>
                            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo strtoupper(htmlentities($user['permission_name'])); ?></td>
                            <td><?php echo $user['user_id']; ?></td>
                            <td>
                                <button type="submit" class="btn btn-block bg-warning text-gray-100">
                                    Update User
                                </button>
                            </td>
                        </form>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- End of All Users -->
</div>