<?php $page = "classes.php"; ?>
<div class="container">
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
    <form method="POST" action="<?php echo generateUrl('/handlers/create-class-handler.php')?>">
    <legend class="border-bottom mb-4">Create Classes</legend>
    <div class="form-group">
        <label for="courseName">Course Name</label>
        <input type="text" class="form-control" id="courseName"  name="courseName" placeholder="Computer Science I" required="true">
    </div>
    <div class="form-group">
        <label for="courseNumber">Course Number</label>
        <input type="number" class="form-control" id="courseNumber" name="courseNumber" placeholder="121" required="true">
    </div>
    <div class="form-group">
        <label for="courseDescription">Course Description</label>
        <textarea class="form-control" id="courseDescription" name="courseDescription" rows="3"></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>