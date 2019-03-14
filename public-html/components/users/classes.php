<?php if (isset($_SESSION["success"])){ ?>
    <div class="alert alert-success">
        <strong>Success!</strong> <?php $_SESSION["success"] ?>
    </div>
<?php } elseif (isset($_SESSION["failure"])) { ?>
    <div class="alert alert-danger">
        <strong>Failure!</strong> <?php $_SESSION["failure"] ?>
    </div>
<?php } ?>

<div class="container">
    <form method="POST" action="<?php echo generateUrl('/handlers/create-class-handler.php')?>">
    <div class="form-group">
        <label for="courseName">Course Name</label>
        <input type="text" class="form-control" id="courseName"  name="courseName" placeholder="Computer Science I" required="true">
    </div>
    <div class="form-group">
        <label for="courseNumber">Course Number</label>
        <input type="number" class="form-control required" id="courseNumber" name="courseNumber" placeholder="121" required="true">
    </div>
    <div class="form-group">
        <label for="courseDescription">Course Description</label>
        <textarea class="form-control" id="courseDescription" name="courseDescription" rows="3"></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>