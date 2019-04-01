<?php 
    $page = "faq.php"; 
?>
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
    <form method="POST" action="<?php echo generateUrl('/handlers/create-faq-handler.php')?>">
    <legend class="border-bottom mb-4">Create FAQ</legend>
    <div class="form-group">
        <label for="question">Question</label>
        <input type="text" class="form-control" id="question" name="question" placeholder="Why is nothing displaying?" required="true">
    </div>
    <div class="form-group">
        <label for="answer">Answer</label>
        <textarea class="form-control" id="answer" name="answer" rows="3" placeholder="Try clearing your cache and cookies and if that does not work contact Ben Peterson."></textarea>
    </div>
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
</div>
