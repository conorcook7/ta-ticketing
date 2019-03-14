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
    <form method="POST" action="<?php echo generateUrl('/handlers/update-user-handler.php')?>">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName"  name="firstName" required="true" placeholder="<?php echo (isset($_POST["firstName"]) ? $_POST["firstName"] : "First Name");?>">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName"  name="lastName" required="true" placeholder="<?php echo (isset($_POST["lastName"]) ? $_POST["lastName"] : "Last Name");?>">
    </div>
    <div class="form-group">
        <label for="userEmail">Email</label>
        <input type="email" class="form-control" id="userEmail" name="userEmail" required="true" placeholder="<?php echo (isset($_POST["email"]) ? $_POST["email"] : "Email");?>">
    </div>
    <label for="permissionID">Permission Level</label>
    <select class="form-control" id="permissionID" name="permissionID" placeholder="<?php echo (isset($_POST["permissionID"]) ? $_POST["PermissionID"] : 1);?>">
      <option>1</option>
      <option>2</option>
      <option>3</option>
    </select>
    <div class="form-group">
        <label for="userID">User ID</label>
        <input type="number" class="form-control" id="userID" name="userID" required="true" placeholder=<?php echo (isset($_POST["userID"]) ? $_POST["userID"] : 0);?>>
    </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>