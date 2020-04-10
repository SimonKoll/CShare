<!--
//login.php
!-->



<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
</head>
<?php

session_start();
include('../db_connect.php');

$message = '';

if (isset($_SESSION['uid'])) {
    header('location:../index/index.php');
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '" . $email . "' and pass = '" . md5($password) . "'");
    if ($row = mysqli_fetch_array($result)) {
        $_SESSION['user_id'] = $row['uid'];
        $_SESSION['user_name'] = $row['user'];
        header("Location: ../index/index.php");
    } else {
        $error_message = "Incorrect Email or Password!!!";
    }
}

?>

<body>
    <div class="container-fluid">
        <div class="row no-gutter">
            <!-- The image half -->
            <div class="col-md-6 d-none d-md-flex bg-image"></div>


            <!-- The content half -->
            <div class="col-md-6 bg-light">
                <div class="login d-flex align-items-center py-5">

                    <!-- Demo content-->
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h3 class="display-4">Login</h3>
                                <p class="text-muted mb-4">Enter your user credentials:</p>
                                <p class="text-danger"><?php echo $message; ?></p>
                                <form method="post">
                                    <div class="form-group mb-3">
                                        <input id="inputEmail" name="email" type="email" placeholder="Email address" required="" autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4">
                                    </div>
                                    <br>

                                    <div class="form-group mb-3">
                                        <input id="inputPassword" name="password" type="password" placeholder="Password" required="" class="form-control rounded-pill border-0 shadow-sm px-4 text-primary">
                                    </div>

                                    <button type="submit" name="login" class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Sign in</button>
                                    or
                                    <br>
                                </form>
                                <a href="register.php"><button class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm">Register</button></a>

                            </div>
                        </div>
                    </div><!-- End -->

                </div>
            </div><!-- End -->

        </div>
    </div>
</body>

</html>
