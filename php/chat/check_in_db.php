<?php
require_once("../db_connect.php");
if (isset($_POST['user'])) {
    $q = "SELECT * FROM users where username = '".$_POST['user']."'";
    $r = mysqli_query($conn, $q);
    if ($r) {
        if (mysqli_num_rows($r)>0) {
            while ($row=mysqli_fetch_assoc($r)) {
                $username = $row['username'];
                echo '<option value="'.$username.'">';
            }
        } else {
            echo '<option value="no such user">';
        }
    } else {
        echo $q;
    }
}
