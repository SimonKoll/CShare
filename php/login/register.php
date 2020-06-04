<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - CShare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
</head>
<?php
include_once("../db_connect.php");
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: ../login/login.php");
}
$error = false;
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    if (!preg_match("/^[a-zA-Z ]+$/", $username)) {
        $error = true;
        $uname_error = "Name must contain only alphabets and space";
    }
    if (!preg_match("/^[a-zA-Z ]+$/", $fname)) {
        $error = true;
        $fname_error = "Name must contain only alphabets and space";
    }
    if (!preg_match("/^[a-zA-Z ]+$/", $lname)) {
        $error = true;
        $lname_error = "Name must contain only alphabets and space";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please Enter Valid Email ID";
    }
    if (strlen($password) < 6) {
        $error = true;
        $password_error = "Password must be minimum of 6 characters";
    }
    if ($password != $cpassword) {
        $error = true;
        $cpassword_error = "Password and Confirm Password doesn't match";
    }
    if (!$error) {
        // $password = "CShare".$password;
        if (mysqli_query($conn, "INSERT INTO users(username,fname, lname, email, pass) VALUES('" . $username . "', '" . $fname . "', '" . $lname . "', '" . $email . "', '" . md5($password) . "')")) {
            $success_message = "Successfully Registered! <a href='login.php'>Click here to Login</a>";
        } else {
            $error_message = "Error in registering...Please try again later!";
        }
    }
}
?>

<body>
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 bg-light">
                <div class="login d-flex align-items-center py-5">

                    <!-- Demo content-->
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-4">Register</h3>

                                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                                    <fieldset>
                                        <legend>Sign Up</legend>
                                        <div class="form-group">
                                            <label for="name">User name</label>
                                            <input type="text" name="username" placeholder="Enter Username" required value="<?php if ($error) {
                                                                                                                                echo $username;
                                                                                                                            } ?>" class="form-control" />
                                            <span class="text-danger"><?php if (isset($uname_error)) {
                                                                            echo $uname_error;
                                                                        } ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">First name</label>
                                            <input type="text" name="fname" placeholder="Enter First Name" required value="<?php if ($error) {
                                                                                                                                echo $fname;
                                                                                                                            } ?>" class="form-control" />
                                            <span class="text-danger"><?php if (isset($fname_error)) {
                                                                            echo $fname_error;
                                                                        } ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Last Name</label>
                                            <input type="text" name="lname" placeholder="Enter Last Name" required value="<?php if ($error) {
                                                                                                                                echo $lname;
                                                                                                                            } ?>" class="form-control" />
                                            <span class="text-danger"><?php if (isset($lname_error)) {
                                                                            echo $lname_error;
                                                                        } ?></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input type="text" name="email" placeholder="Email" required value="<?php if ($error) {
                                                                                                                    echo $email;
                                                                                                                } ?>" class="form-control" />
                                            <span class="text-danger"><?php if (isset($email_error)) {
                                                                            echo $email_error;
                                                                        } ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" name="password" placeholder="Password" required class="form-control" />
                                            <span class="text-danger"><?php if (isset($password_error)) {
                                                                            echo $password_error;
                                                                        } ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Confirm Password</label>
                                            <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
                                            <span class="text-danger"><?php if (isset($cpassword_error)) {
                                                                            echo $cpassword_error;
                                                                        } ?></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
                                        </div>
                                    </fieldset>
                                </form>
                                Already have an account?
                                <br>
                                <a href="login.php"><button name="login" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Sign in</button></a>
                                <span class="text-success"><?php if (isset($success_message)) {
                                                                echo $success_message;
                                                            } ?></span>
                                <span class="text-danger"><?php if (isset($error_message)) {
                                                                echo $error_message;
                                                            } ?></span>

                            </div>
                        </div>
                    </div><!-- End -->

                </div>
            </div><!-- End -->


            <!-- The content half -->
            <div class="col-md-6 d-none d-md-flex register-bg-image"></div>


        </div>
    </div>
</body>

</html>
