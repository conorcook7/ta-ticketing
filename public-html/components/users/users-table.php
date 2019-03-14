<div class="container-fluid">
        <!-- All Users Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
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
                    $users = $dao->getUsers();
                    foreach($users as $user) { 
                  ?>
                        <tr>
                        <form method="POST" action="../pages/admin.php?id=users-form">
                            <td name="firstName" value="<?php echo htmlspecialchars($user['first_name']); ?>"><?php echo htmlspecialchars($user['first_name']); ?></td>
                            <td name="lastName" value="<?php echo htmlspecialchars($user['last_name']); ?>"><?php echo htmlspecialchars($user['last_name']); ?></td>
                            <td name="email" value="<?php echo htmlspecialchars($user['email']); ?>"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td name="permissionID" value="<?php echo $user['permission_id']; ?>"><?php echo $user['permission_id']; ?></td>
                            <td name="userID" value="<?php echo $user['user_id']; ?>"><?php echo $user['user_id']; ?></td>
                            <td>
                            <button type="submit" class="btn btn-block bg-gradient-warning text-gray-100">
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