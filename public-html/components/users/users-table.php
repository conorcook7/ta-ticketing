<?php
    /**
     * Copyright 2019 Boise State University
     * Licensed under MIT (https://github.com/BoiseState/ta-ticketing/blob/master/LICENSE)
     */

    session_start();
    $page = "users-table.php";

    $dao = new Dao();
    $permissions = $dao->getPermissionLevels();
    $courses = $dao->getAvailableCourses();
?>

<!--  Form -->
<div id="update-user-div" class="px-4 mb-4" style="display: none">
    <form method="POST" class="form-group w-50" action="<?php echo generateUrl("/handlers/update-user-handler.php"); ?>">
        <div class="form-group">
            <label for="firstName" class="mb-0">First Name</label>
            <input type="text" id="update-first-name" class="form-control" name="firstName" value="" required="true"/>
        </div>
        <div class="form-group">
            <label for="lastName" class="mb-0">Last Name</label>
            <input type="text" id="update-last-name" class="form-control" name="lastName" value="" required="true"/>
        </div>
        <div class="form-group">
            <label for="email" class="mb-0">Email</label>
            <input type="email" id="update-email" class="form-control" name="userEmail" value="" required="true"/>
        </div>
        <div class="form-group">
            <label for="permissionID" class="mb-0">Permission Level</label>
            <select id="update-permission-id" class="form-control" name="permissionID">
                <?php
                    foreach ($permissions as $permission) {
                      echo "<option value='" . $permission["permission_id"] . "'>" . $permission["permission_name"] . "</option>";
                    }
                ?>
                <option value="0">DELETE USER</option>
                <option selected="selected" value="-1">CREATE USER</option>
            </select>
        </div>
        <div id="ta-creation">
            <div class="form-group">
                <label for="startTime">Start Time</label>
                <input type="time" class="form-control" id="startTime" name="startTime" value="09:00">
            </div>
            <div class="form-group">
                <label for="endTime">End Time</label>
                <input type="time" class="form-control" id="endTime" name="endTime" value="17:00">
            </div>
            <div class="form-group">
                <label for="courseName">Course</label>
                <select class="form-control" id="courseId" name="courseId">
                    <?php
                        foreach($courses as $course){
                            echo "<option value='" . htmlentities($course["available_course_id"]) . "'>" .
                                strtoupper(htmlentities($course["course_number"] . " - " . $course["course_name"])) . 
                                "</option>";
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="userID" class="mb-0">User ID</label>
            <input type="number" id="update-user-id" class="form-control" name="userID" value="" readonly/>
        </div>
        <div class="form-group">
            <button type="submit" id="update-submit" class="btn btn-primary my-2 mr-2">Finish Editing</button>
            <button type="button" id="update-cancel" class="btn btn-danger my-2">Cancel</button>
        </div>
    </form>
</div>

<!-- All Users Table -->
<div class="container-fluid">
  <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">All Users</h6>
                <span>
                    <button type="button" id="user-add-btn" class="btn btn-success">
                        <i class="fas fa-plus-square fa-xl text-white pr-2"></i>Add User
                    </button>
                </span>
            </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th class="center">ID</th>
                <th class="center">First Name</th>
                <th class="center">Last Name</th>
                <th class="center">Email</th>
                <th class="center">Permission Level</th>
                <th class="center">Update User</th>
              </tr>
            </thead>
            <tbody>
            <?php 
                $page = strtoupper($_SESSION["user"]["permission"]) == "ADMIN" ? "admin.php?id" : "professor.php?page";
              $users = $dao->getUsers();
              foreach($users as $user) { 
            ?>
                  <tr>
                      <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                      <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                      <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                      <td><?php echo htmlspecialchars($user['email']); ?></td>
                      <td><?php echo strtoupper(htmlentities($user['permission_name'])); ?></td>
                      <td>
                          <button type="button" class="btn btn-block bg-warning text-gray-100 update-user-btn">
                              Update User
                          </button>
                      </td>
                  </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End of All Users -->
</div>