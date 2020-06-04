<!-- <?php
include_once("../db_connect.php");
session_start();

if (!isset($_SESSION['uid'])) {
    header("Location: ../login/login.php");
}
$uid = $_SESSION['user_id'];
$sql_1 = "SELECT username FROM users WHERE uid=$uid";


$uname =    mysqli_query($conn, $sql_1);

$row_1 = mysqli_fetch_assoc($uname);

?>

<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="../../css/style.css">
<link rel="stylesheet" href="../../css/bootstrap.min.css">
<link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
<style>
  html,
  body {
    text-align: left;
    height: 100%;
    overflow: hidden;
    padding: 0%;
    margin: 0%;
  }

  a,
  p {
    font-size: 12px;
    text-decoration: none;
  }

  #container {
    box-shadow: 2px 2px 10px #000000;
    width: 90%;
    height: 80%;
    margin: 5%;
    overflow: hidden;
  }

  #menu {
    text-align: center;
    background: #87cefa;
    color: white;
    padding: 1%;
    font-size: 30px;
    text-decoration: none;
  }

  #left-col,
  #right-col {
    position: relative;
    float: left;
    height: 85%;
  }

  #left-col {
    margin-top: 2%;
    color: #000000;
    width: 30%;
  }

  #right-col {
    margin-top: 2%;
    color: black;
    width: 69%;
    border: 1px solid #efefef;
  }

  #left-col-container,
  #right-col-container {
    width: 100%;
    height: 100%;
    margin: 0px auto;
    overflow: auto;
  }

  .back-white,
  .back-blue {


    padding: 5px;
    margin: 0px auto;
    margin-top: 2px;

  }



  .back-blue {
    height: 60px;
    border: 1px solid black;
    background: #5097c3;
  }

  .userimage {
    float: left;
    width: 50px;
    height: 50px;
    margin-right: 5px;
  }

  #messages-container {
    height: 80%;
    overflow: auto;
  }

  .textarea {
    width: 100%;
    height: 10%;
    position: absolute;
    bottom: 1%;
    margin: 0px auto;
  }

  .message-gray,
  .message-white {
    border: 1px solid #000000;
    width: 96%;
    padding: 5px;
    margin: 0px auto;
    margin-top: 2px;
    overflow: auto;
  }

  .message-gray {
    background: #efefef;
  }

  #new-message {
    display: none;
    box-shadow: 2px 10px 30px #000000;
    width: 500px;
    position: fixed;
    top: 20%;
    background: white;
    z-index: 2;
    left: 50%;
    transform: translate(-50%, 0);
    border-radius: 5px;
    overflow: auto;
  }

  .m-header,
  .m-footer {
    background: #5097c3;
    margin: 0px;
    color: white;
    text-align: left;
    padding: 5px;
  }

  .m-header {
    font-size: 20px;
    text-align: center;
  }

  .m-body {
    padding: 5px;
  }

  .message-input {
    width: 96%;
  }
</style>

<body>
  <?php
  $getimagestring  = "select path from images where uid=" . $uid;
  $_db_host = "localhost";
  $_db_datenbank = "cshare";
  $_db_username = "root";
  $_db_passwort = "";
  $conn = new mysqli($_db_host, $_db_username, $_db_passwort, $_db_datenbank);
  //Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  $result = $conn->query($getimagestring);
  $row = mysqli_fetch_array($result);
  $src = $row['path'];
if ($src === null) {
    $src = "../../Files\user_pics\default.png";
}
  ?>
  <?php ?>
  <div id="new-message">
    <p class="m-header">New Message</p>
    <p class="m-body">
    <form align="center" method="post">
      <input class="message-input" list="user" onkeyup="check_in_db()" type="text" placeholder="Username"
        name="user_name" id="user_name">
      <datalist id="user"></datalist><br><br>
      <textarea class="message-input" placeholder="your message" name="message" cols="30" rows="10"></textarea><br><br>
      <button type="submit" value="send" name="send" id="send">Send
      </button>
      <button onclick="document.getElementById('new-message').style.display='none'">Cancel</button> </form>
    </p>
    <p class="m-footer"></p>
  </div>

  <?php
  require_once("../db_connect.php");
  if (isset($_POST['send'])) {
      $sender_name = $row_1['username'];
      $reciever_name =$_POST['user_name'];
      $message = $_POST['message'];
      $date = date("Y-m-d h:i:sa");
      $q='INSERT INTO messages (id,sender_name,reciever_name,message_text,date_time) 
      VALUES("","'.$sender_name.'","'.$reciever_name.'","'.$message.'","'.$date.'")';
      $r=mysqli_query($conn, $q);
      if ($r) {
          //message sent
          header("location:index.php?user=".$reciever_name);
          echo "message sent";
      } else {
          //problem
          echo "problem with".$q;
      }
  }
  ?>


  <script>
    document.getElementById('send').disabled = true;

    function check_in_db() {
      var user_name = document.getElementById("user_name").value;
      $.post("check_in_db.php", {
          user: user_name
        },

        function(data, status) {
          // alert(data);
          if (data == '<option value="no such user">') {
            document.getElementById('send').disabled = true;
          } else {

            document.getElementById('send').disabled = false;

          }

          document.getElementById('user').innerHTML = data;
        });
    };
  </script>
  <div id="container">
    <div id="menu">
      <?php echo $row_1['username']; ?>
      <?php echo " <a style='float:right; color:#5686a3;' href='../login/logout.php'>Logout </a>"; ?>
    </div>
    <div id="left-col">
      <div id="left-col-container">
        <div onclick="document.getElementById('new-message').style.display='block'" class="back-white">
          <p align="center">New Message</p>
        </div>
        <div class="back-blue">
          <img class="userimage" src="<?php echo $src ?>"
            alt="profilepic">
          test
        </div>




      </div>
    </div>
    <div id="right-col">
      <div id="right-col-container">
        <div id="messages-container">
          <?php
          $q='SELECT * FROM messages WHERE sender_name ="'.$row_1['username'].'" 
          AND reciever_name ="'.$_GET['user'].'" 
          OR 
          sender_name ="'.$_GET['user'].'" 
          AND reciever_name="'.$row_1['username'].'"
          ';
          $r=mysqli_query($conn, $q);
          if ($r) {
              while ($row=mysqli_fetch_assoc($r)) {
                  $sender_name =$row['sender_name'];
                  $reciever_name = $row['reciever_name'];
                  $message = $row['message_text'];

                  if ($sender_name == $row_1['username']) {
                      //gray
                      ?>
          <?php
                  } else {
                      //white
                  }
              }
          } else {
              //problem
              echo "problem with".$q;
          }
          
          
          ?>




          <div class="message-white">
            <a href="#">You</a>
            <p> Message with white background here</p>
          </div>
        </div>
        <textarea placeholder="Your message here..." name="" class="textarea" cols="30" rows="10"></textarea>
      </div>
    </div>


  </div>

</body>

</html> -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
  <title>Chat - under Construction</title>
  <style>
    .button {
      background-color: #87cefa;
      border: none;
      color: white;
      padding: 16px 32px;
      text-align: center;
      font-size: 16px;
      margin: 4px 2px;
      opacity: 0.6;
      transition: 0.3s;
      display: inline-block;
      text-decoration: none;
      cursor: pointer;
    }

    .button:hover {
      opacity: 1
    }
  </style>
</head>

<body>
  <h1 style="text-align: center; margin-top:50vh;">Sorry, but we are working on this feature :/ </h1>
  <a href="../index/index.php"><button class="button">
      <h3 style="text-align: center;">Go back to index</h3>
    </button>
  </a>
</body>

</html>