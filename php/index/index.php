<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index - CShare</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="../../css/style.css" rel="stylesheet" media="screen">

    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
</head>

<body id="overviewIndex">
    <?php
    include_once("../db_connect.php");
    session_start();

    if (isset($_SESSION['uid'])) {
        header("Location: ../index/index.php");
    }
    $uid = $_SESSION['user_id'];
    $sql_1 = "SELECT username FROM users WHERE uid=$uid";


    $uname =    mysqli_query($conn, $sql_1);

    $row_1 = mysqli_fetch_assoc($uname);

    //
    ?>

    <div class="container">
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
            </ul>
        </div>

        <p align="right">Hi -<?php echo $row_1["username"] ?> - <a href="../login/logout.php">Logout</a></p>
        <div>
        </div>
        <div class="jumbotron text-center">
            <h1>Overview</h1>
            <p>Your personal page</p>
        </div>





    </div>
    <div class="jumbotron text-center">
        <div class="container">
            <div class="row">
                <div class="col-sm-3"><a href="../chat/index.php"><button type="button" class="btn btn-outline-primary">CHAT</button></a><br>
                </div>
                <div class="col-sm-3">
                    <a href="../map/map.php"><button type="button" class="btn btn-outline-primary">MAP</button></a><br>
                </div>
                <div class="col-sm-3">
                    <a href="../profile/index.php"><button type="button" class="btn btn-outline-primary">PROFILE</button></a><br>
                </div>
                <div class="col-sm-3">
                    <a href="../contact/index.html"><button type="button" class="btn btn-outline-primary">Contact us</button></a><br>
                </div>

            </div>
        </div>
    </div>
</body>

</html>