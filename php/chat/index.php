<!--
//index.php
!-->

<?php

include('../db_connect.php');

session_start();

// if (!isset($_SESSION['uid'])) {
//     header('location:../login/login.php');
// }

$uid = $_SESSION['user_id'];
$sql_1 = "SELECT username FROM users WHERE uid=$uid";


$uname =    mysqli_query($conn, $sql_1);

$row1 = mysqli_fetch_assoc($uname);

?>

<html>

<head>
    <title>Chats - CShare</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="../../css/style.css">

    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
</head>

<body id="overviewChat">
    <div class="jumbotron text-center">
        <br />

        <h3 align="center">Your last Conversations</a></h3><br />
        <br />
    </div>
    <div class="table-responsive">
        <div class="jumbotron text-center">

            <h4 align="center">Users</h4>
            <br />
            <p align="right">Hi -<?php echo $row1["username"] ?> - <a href="../login/logout.php">Logout</a></p>
            <div id="user_details"></div>
        </div>
        <a href="../index/index.php"><button type="button" class="btn btn-outline-primary">BACK TO INDEX</button></a>

        <script>
            $(document).ready(function() {

                fetch_user();

                function fetch_user() {
                    $.ajax({
                        url: "fetch_user.php",
                        method: "POST",
                        success: function(data) {
                            $('#user_details').html(data);
                        }
                    })
                }

                function update_last_activity() {
                    $.ajax({
                        url: "update_last_activity.php",
                        success: function() {

                        }
                    })
                }


            });
        </script>
</body>

</html>