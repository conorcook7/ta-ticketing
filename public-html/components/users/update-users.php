<?php $page = "update-users.php"; ?>
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
    
    <form method="POST" action="<?php echo generateUrl('/handlers/update-user-handler.php')?>">
    <div class="form-group">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" id="firstName"  name="firstName" required="true" <?php echo (isset($_POST["firstName"]) ? "value=\"" . $_POST["firstName"] : "placeholder=\"First Name");?>">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName"  name="lastName" required="true" <?php echo (isset($_POST["lastName"]) ? "value=\"" . $_POST["lastName"] : "placeholder=\"Last Name");?>">
    </div>
    <div class="form-group">
        <label for="userEmail">Email</label>
        <input type="email" class="form-control" id="userEmail" name="userEmail" required="true" <?php echo (isset($_POST["email"]) ? "value=\"" . $_POST["email"] : "placeholder=\"Email");?>">
    </div>
    <label for="permissionID">Permission Level</label>
    <select class="form-control" id="permissionID" name="permissionID">
    <?php 
    $dao = new Dao();
    $permissions = $dao->getPermissionLevels();
    $count = 0;
    foreach ($permissions as $perm) { 
      $count++;
      if($_POST["permissionID"] == $count) { ?>
        <option selected="selected"><?php echo $perm['permission_id'] . " - " . $perm['permission_name'];?></option>
      <?php } else { ?>
        <option><?php echo $perm['permission_id'] . " - " . $perm['permission_name'];?></option>
      <?php } ?>
    <?php } ?>
      <?php if($_POST["permissionID"] == 0) { ?>
        <option selected="selected">0 - Delete User</option>
      <?php } else { ?>
        <option>0 - Delete User</option>
      <?php } ?>
    </select>
    <div class="form-group">
        <label for="userID">User ID</label>
        <input type="number" class="form-control" id="userID" name="userID" required="true" value=<?php echo (isset($_POST["userID"]) ? $_POST["userID"] : -1);?> readonly>
    </div>
        <button type="submit" class="btn btn-primary">Add/Update User</button>
    </form>
</div>
