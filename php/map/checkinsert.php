<?php
session_start();
include('../db_connect.php');
$uid = $_SESSION['user_id'];
$sql_1 = "SELECT username FROM users WHERE uid=$uid";


$uname = mysqli_query($conn, $sql_1);

$row1 = mysqli_fetch_assoc($uname);

$uid = $row1["username"];

$brand = $_POST['brand'];
$model = $_POST['model'];
$str = explode("&", $_POST['form']);

$str = str_replace(array('%20'), ' ', $str);
$str = str_replace(array('%C3%9F'), 'ß', $str);
$zip = substr($str[0], 4);

$town = substr($str[1], 5);

$street = substr($str[2], 7);
$searchstring = $street . ',+' . $zip . '+' . $town;
echo $searchstring;

// echo $searchstring . $brand . $model;
$queryString = http_build_query([
    'auth' => '866962305767641128561x4837',
    'scantext' => $searchstring,
    'region' => 'Europe',
    'geojson' => '1'
]);


$ch = curl_init(sprintf('%s?%s', 'https://geocode.xyz', $queryString));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$json = curl_exec($ch);

curl_close($ch);

$apiResult = json_decode($json, true);
$lat = $apiResult['properties']['lat'];
var_dump($lat);
$long = $apiResult['properties']['lon'];
var_dump($long);
$sql = "INSERT INTO cshare.adresse (strasse, plz, longitude, latitude, id, stadt) VALUES ('" . $street . "', " . $zip . "," . $lat . "," . $long . ", NULL,'" . $town . "')";

if ($conn->query($sql) === TRUE) {
    $checkSQL = "SELECT * FROM cshare.adresse";
    $result = $conn->query($checkSQL);
    echo "Returned rows are: " . $result->num_rows;
    var_dump($result);
    //     echo "New record created successfully";
    //     $sql1 = "SELECT 'id' from adresse where latitude=" . $lat . "and longitude=" . $long . ";";
    //     $addr_id = mysqli_query($conn, $sql1);
    //     $row_1 = mysqli_fetch_assoc($addr_id);
    // var_dump($row_1);
    //     $sql1 = "SELECT 'id' from cars.cars WHERE brand='" . $brand . "'and model='" . $model . "'";
    //     $car_id = mysqli_query($conn, $sql1);
    //     $row_2 = mysqli_fetch_assoc($car_id);
    //     var_dump($row_2);
    // $sql2 = "INSERT INTO `cars_to_rent` (`cars_id`, `users_uid`, `adress_id`) VALUES ($car_id, $uid, $addr_id)";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
