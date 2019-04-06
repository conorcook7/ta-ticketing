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
        <input type="text" class="form-control" id="firstName"  name="firstName" required="true" value="<?php echo (isset($_POST["firstName"]) ? $_POST["firstName"] : "First Name");?>">
    </div>
    <div class="form-group">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" id="lastName"  name="lastName" required="true" value="<?php echo (isset($_POST["lastName"]) ? $_POST["lastName"] : "Last Name");?>">
    </div>
    <div class="form-group">
        <label for="userEmail">Email</label>
        <input type="email" class="form-control" id="userEmail" name="userEmail" required="true" value="<?php echo (isset($_POST["email"]) ? $_POST["email"] : "Email");?>">
    </div>
    <label for="permissionID">Permission Level</label>
    <select class="form-control" id="permissionID" name="permissionID">
      <?php if($_POST["permissionID"] == 1) { ?>
        <option selected="selected">1</option>
      <?php } else { ?>
        <option>1</option>
      <?php } ?>

      <?php if($_POST["permissionID"] == 2) { ?>
        <option selected="selected">2</option>
      <?php } else { ?>
        <option>2</option>
      <?php } ?>

      <?php if($_POST["permissionID"] == 3) { ?>
        <option selected="selected">3</option>
      <?php } else { ?>
        <option>3</option>
      <?php } ?>
      
      <?php if($_POST["permissionID"] == 0) { ?>
        <option selected="selected">0</option>
      <?php } else { ?>
        <option>0</option>
      <?php } ?>
    </select>
    <div class="form-group">
        <label for="userID">User ID</label>
        <input type="number" class="form-control" id="userID" name="userID" required="true" value=<?php echo (isset($_POST["userID"]) ? $_POST["userID"] : -1);?> readonly>
    </div>
        <button type="submit" class="btn btn-primary">Add/Update User</button>
    </form>
</div>
