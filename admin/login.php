<?php 
include '../backend/init.php';
if ($getFromU->loggedIn() === true) {
    header('Location: /index.php');
}if(isset($_POST["submit"])){
    $email = $_POST['inputEmailAddress'];
    $password = $_POST['inputPassword'];
    if(!empty($email) or !empty($password)) {
        $email = $getFromU->checkInput($email);
        $password = $getFromU->checkInput($password);
  
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          $errorMsg = "Invalid format";
        }else {
          if($getFromA->login($email, $password) === false){
            $errorMsg = "The email or password is incorrect!";
          }else{
            $getFromA->login($email, $password);
          }
        }
    }else {
        $errorMsg = "Please enter username and password!";
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <form method="post" action="">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4"> Admin Login</h3>
                                        <div class="text-center errormsg" style="color:red;"><?php if(isset($errorMsg)){echo $errorMsg;}?></div>
                                    </div>
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                            <input class="form-control py-4" id="inputEmailAddress" name="inputEmailAddress" type="email" placeholder="Enter email address" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Enter password" required />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            
                                            <input type="submit" name="submit" id="submit" class="btn btn-primary" value="Login">
                                        </div>

                                    </div>
                                   
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="/privacypolicy.php">Privacy Policy</a>
                            &middot;
                            <a href="/t&c.php">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
<?php

?>