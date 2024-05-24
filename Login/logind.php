<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css/animations.css">  -->
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/icons.min.css">
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="css/toastr.min.css">
    <!-- <link rel="stylesheet" href="css/main.css">   -->
    <!-- <link rel="stylesheet" href="css/login.css"> -->
        
    <title>Login</title>

    
    
</head>
<body>
    <?php

    //learn from w3schools.com
    //Unset all the server side variables

    session_start();

    $_SESSION["user"]="";
    $_SESSION["usertype"]="";
    
    // Set the new timezone
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d');

    $_SESSION["date"]=$date;
    

    //import database
    include("connection.php");

    



    if($_POST){

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $result= $database->query("select * from webuser where email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype=='p'){
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){


                    //   Patient dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    
                    header('location: patient/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }elseif($utype=='a'){
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows==1){


                    //   Admin dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    
                    header('location: admin/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }


            }elseif($utype=='d'){
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows==1){


                    //   doctor dashbord
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }






        
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }

    ?>





<div class="account-pages my-5 pt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="card-body pt-0">
                        <div class="p-2">
                        <form action="" method="POST" >                            <h1> Hello Doctor !! </h1><br>
                            <h5><p>Please Sign in</p></h5>
                                <div class="mb-3">
                                    <label for="useremail">Email <span class="text-danger">*</span></label>
                                    <input name="useremail" type="email" class="form-control"
                                           placeholder="Enter Address" autocomplete="email" autofocus required>
                                </div>
                                <div class="mb-3">
                                    <label for="userpassword">Password :<span class="text-danger">*</span></label>
                                    <input type="Password" name="userpassword" class="form-control"
                                           placeholder="Enter password" required>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary w-100 waves-effect waves-light"
                                            type="submit" name="Login">Log In
                                    </button>
                                </div>
                                <br>
                                <div class="flex-shrink-0">
                                                    <a href="login.php" class="btn btn-primary" style="width: 198px; height: 38px;">Login as Patient</a>
                                                    <a href="logina.php" class="btn btn-primary" style="width: 198px; height: 38px;">Login as Admin</a>
                                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>Don't have an account? <a href="signup.php" class="fw-medium text-primary">Sign Up here</a></p>
                    <!-- <p>© 2024 CareWave Plus. Crafted with <i class="mdi mdi-heart text-danger"></i> by DreamersDesire</p> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/metisMenu.min.js"></script>
<script src="js/simplebar.min.js"></script>
<script src="js/waves.min.js"></script>
<script src="js/toastr.js"></script>
<script src="js/app.min.js"></script>

</body>
</html>