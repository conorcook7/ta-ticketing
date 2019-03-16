<?php
    require_once "../components/header.php";
?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">

                        <form class="form-signin form-containter" action="">
                            <img class="mb-4 image" src="https://www.cludo.com/wp-content/uploads/2018/10/Boise-State-University-Logo.png" alt="" width="300" height="194">
                             <h1 id="please-sign" class="h3 mb-3 font-weight-normal">Please sign in</h1>
                            <div class="form-group">
                                <label for="inputEmail" class="sr-only">Email address</label>
                                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="sr-only">Password</label>
                                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fas fa-sign-in-alt"></i>     Sign in</button>
                            </div>
                             <p id="please-sign" class="mt-5 mb-3">&copy; Boise State University 2019</p>
                         </form>
                        </div>
                    </div>
                </div>  
            </div>
            <?php echo "<pre>" . print_r($_SESSION, 1) . "</pre>"; ?> 
        </div>

    <?php require_once "../components/scripts.php"; ?>
    <script src="../js/client-update.js"></script>  
  </body>
</html>