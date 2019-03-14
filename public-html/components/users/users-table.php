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
                      <th class="center">Student Name</th>
                      <th class="center">Email</th>
                      <th class="center">Permission Level</th>
                      <th class="center">User ID</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $users = $dao->getUsers();
                    foreach($users as $user) { 
                  ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['permission_id']; ?></td>
                            <td><?php echo $user['user_id']; ?></td>
                        </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- End of All Users -->
</div>