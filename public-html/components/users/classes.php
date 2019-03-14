<div class="container">
    <form method="POST" action="<?php echo generateUrl('/handlers/create-class-handler.php')?>">
    <div class="form-group">
        <label for="courseName">Course Name</label>
        <input type="text" class="form-control" id="courseName"  placeholder="Computer Science I">
    </div>
    <div class="form-group">
        <label for="courseNumber">Course Number</label>
        <input type="number" class="form-control" id="courseNumber" placeholder="121">
    </div>
    <div class="form-group">
        <label for="courseDescription">Course Description</label>
        <textarea class="form-control" id="courseDescription" rows="3"></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>