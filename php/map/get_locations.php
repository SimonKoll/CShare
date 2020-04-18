<?php
include_once("../db_connect.php");
try{
  $sql="SELECT * FROM locations";
  $location=mysqli_query($conn, $sql);

$row1=mysqli_fetch_all($location);
var_dump($row1);
} catch (Exception $e) {
echo $e->getMessage();
}?>
