<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cshare";
$conn = mysqli_connect($servername, $username, $password, $dbname);
$connect = new PDO("mysql:host=localhost;dbname=cshare","root","");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
date_default_timezone_set('Europe/Vienna');

function fetch_user_last_activity($user_id, $conn)
{
 $query = "
 SELECT * FROM login_details 
 WHERE user_id = '$user_id' 
 ORDER BY last_activity DESC 
 LIMIT 1
 ";
 $statement = $conn->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  return $row['last_activity'];
 }
}

?>

