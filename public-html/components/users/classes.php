<?php $page = "classes.php"; ?>
<div class="container-fluid">
    <?php if (isset($_SESSION["success"])){ ?>
        <div class="alert alert-success">
            <strong>Success!</strong> <?php echo $_SESSION["success"]; ?>
        </div>
    <?php } elseif (isset($_SESSION["failure"])) { ?>
        <div class="alert alert-danger">
            <strong>Failure!</strong> <?php echo $_SESSION["failure"]; ?>
        </div>
    <?php }
        unset($_SESSION["failure"]);
        unset($_SESSION["success"]);
    ?>
    <form method="POST" action="<?php echo generateUrl('/handlers/class-handler.php')?>">
    <?php
        if(isset($_POST["classID"])){?>
        <input type="hidden" name="classID" value="<?php echo $_POST["classID"]; ?>"/>
    <?php    
        }
    ?>
    <legend class="border-bottom mb-4">Create Class</legend>
    <div class="form-group">
        <label for="courseName">Course Name</label>
        <input type="text" class="form-control" id="courseName"  name="courseName" <?php echo (isset($_POST["courseName"]) ? "value=\"" . $_POST["courseName"] : "placeholder=\"Computer Science 1");?>" required="true">
    </div>
    <div class="form-group">
        <label for="courseNumber">Course Number</label>
        <input type="text" class="form-control" id="courseNumber" name="courseNumber" <?php echo (isset($_POST["courseNumber"]) ? "value=\"" . $_POST["courseNumber"] : "placeholder=\"CS121");?>" required="true">
    </div>
    <div class="form-group">
        <label for="courseDescription">Course Description</label>
        <textarea class="form-control" id="courseDescription" name="courseDescription" rows="3" placeholder="Introduction to Java Programming"><?php
        if(isset($_POST["courseDescription"])){
            echo htmlspecialchars($_POST["courseDescription"]);
        }
        ?></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Add/Update Course</button>
    </form>
    <?php
        unset($_POST["courseName"]);
        unset($_POST["courseNumber"]);
        unset($_POST["courseDescription"]); 
    ?>
</div>
<div class="container-fluid mt-4">
        <!-- All Classes Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">All Classes</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table class="table table-bordered data_table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th class="center">Course Number</th>
                      <th class="center">Course Name</th>
                      <th class="center">Course Description</th>
                      <th class="center">Update</th>
                      <th class="center">Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $allClasses = $dao->getAvailableCourses();
                    foreach($allClasses as $class) { 
                  ?>
                    <tr>
                    <form method="POST" action="<?php echo generateUrl('/pages/admin.php?id=classes')?>">
                        <input type="hidden" name="courseNumber" value="<?php echo htmlspecialchars($class['course_number']); ?>"/>
                        <input type="hidden" name="courseName" value="<?php echo htmlspecialchars($class['course_name']); ?>"/>
                        <input type="hidden" name="courseDescription" value="<?php echo $class['course_description']; ?>"/>
                        <input type="hidden" name="classID" value="<?php echo $class['available_course_id']; ?>"/>
                        <td><?php echo htmlspecialchars($class['course_number']); ?></td>
                        <td><?php echo htmlspecialchars($class['course_name']); ?></td>
                        <td><?php echo htmlspecialchars($class['course_description']); ?></td>
                        <!-- Button trigger modal for ticket descriptions-->
                        <?php echo ('
                        <td>
                        <button type="button" class="btn btn-block bg-primary text-gray-100" data-toggle="modal" data-target="#course-description' . $class["available_course_id"] . '">
                            More Info
                        </button>
                        <!-- Modal for ticket descriptions-->
                        <div class="modal fade" id="course-description' . $class["available_course_id"] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Description</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">' . htmlentities($class["course_description"]) . '</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </td>
                        ')
                        ?>
                        <td>
                            <button type="submit" name="button_id" value="update" class="btn btn-block bg-warning text-gray-100">
                                Update Class
                            </button>
                        </td>
                    </form>
                    <form method="POST" action="<?php echo generateUrl('/handlers/class-handler.php')?>">
                        <input type="hidden" name="classID" value="<?php echo $class['available_course_id']; ?>"/>
                        <input type="hidden" name="delete" value=1 />
                        <td>
                            <button type="submit" name="button_id" value="delete" class="btn btn-block bg-danger text-gray-100">
                                Delete Class
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
        <!-- End of All Classes -->
    
</div>