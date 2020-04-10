<?php $brand_js = key($_POST);
include_once("../db_connect.php");
session_start();
echo "<option>Select car</option>";
$sql_model = "SELECT * FROM cars.cars  WHERE brand='" . $brand_js . "' GROUP BY model";
$model = mysqli_query($conn, $sql_model);
if (mysqli_num_rows($model) > 0) {
    while ($row = mysqli_fetch_assoc($model)) {
        echo "<option value=" . $row["model"] . ">" . $row["model"] . "</option>";
    }

}
