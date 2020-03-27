<!--
//login.php
!-->

<?php

session_start();
include('../db_connect.php');

$message = '';

if (isset($_SESSION['uid'])) {
    header('location:../index/index.php');
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
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

<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
</head>

<body>
    <div class="container">
        <br />

        <h3 align="center">Login</a></h3><br />
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">Login here:</div>
            <div class="panel-body">
                <form method="post">
                    <p class="text-danger"><?php echo $message; ?></p>
                    <div class="form-group">
                        <label>Enter EMail</label>
                        <input type="text" name="username" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <label>Enter Password</label>
                        <input type="password" name="password" class="form-control" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" name="login" class="btn btn-info" value="Login" /> or 
                     <a href="./register.php">   <input type="button" name="register" class="btn btn-info" value="Register" /> </a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</body>

</html>