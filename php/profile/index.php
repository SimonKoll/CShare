<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Your Account - CShare</title>
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" href="../../css/style.css">

	<link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
</head>

<body>
	<?php
	//if (!isset($_SESSION['uid'])) {
	//	header('location:../login/login.php');
	//} 
	?>
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


	$uid = $_SESSION['user_id'];
	$sql_1 = "SELECT fname FROM users WHERE uid=$uid";

	$sql_2 = "SELECT lname FROM users WHERE uid=$uid";

	$ufname =	mysqli_query($conn, $sql_1);
	$ulname =	mysqli_query($conn, $sql_2);
	$row1 = mysqli_fetch_assoc($ufname);
	$row2 = mysqli_fetch_assoc($ulname);


	?>
	<div class="container">
		<p align="right">Hi -<?php echo $row_1["username"] ?> - <a href="../login/logout.php">Logout</a></p>
		<div class="row profile">
			<div class="col-md-3">
				<div class="profile-sidebar">
					<div class="profile-usertitle">
						<div class="profile-usertitle-name">
							<?php echo $row1["fname"] . " " . $row2['lname'];
							?>
						</div>
					</div>
					<div class="profile-userbuttons">
						<button type="button" class="btn btn-danger btn-sm">Message</button>
					</div>



					<a href="../index/index.php">HOME</a>
				</div>
			</div>
			<div class="col-md-9">
				<div class="profile-content">
					Letzen Fahrten, eigene Autos,...
					<form action="./index.php" method="POST" enctype="multipart/form-data">
						Select image to upload:
						<input type="file" name="fileToUpload" id="fileToUpload">
						<input type="submit" value="Upload Image" name="submit">

					</form>


				</div>
			</div>
		</div>
	</div>
	<br>
	<br>
</body>
<?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

if (isset($_POST["submit"])) {
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	if ($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}
if (file_exists($target_file)) {
	echo "Sorry, file already exists.";
	$uploadOk = 0;
}
if ($_FILES["fileToUpload"]["size"] > 500000) {
	echo "Sorry, file too large.";
	$uploedOk = 0;
}
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
	echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	$uploadOk = 0;
}


if ($uploadOk == 0) {
	echo "Sorry, your file was not uploaded";
} else {
	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$insertStatement = "insert into images  values ('" .
			$uid . "" . $target_file . "');";
		//var_dump($insertStatement);
		if ($_res = $conn->query($insertStatement)) {
			echo "<br>Image $target_file has been added to the database.";
		} else {
			echo "<br> NO insertion into database.";
		}
		$conn->close();
	}
}
?>

</html>