<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Your Account - CShare</title>
	<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

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

	if (!isset($_SESSION['uid'])) {
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
	$sql_3 ="SELECT path FROM images WHERE uid=$uid";

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
						<form action="./index.php" method="POST" enctype="multipart/form-data">
							Select Profile Picture:

							<input type="file" name="fileToUpload" id="fileToUpload" >
							<input type="submit" value="Upload Image" name="submit">

						</form>
					</div>



					<a href="../index/index.php">HOME</a>
				</div>
			</div>
			<div class="col-md-9">
				<div class="profile-content">
					Letzen Fahrten, eigene Autos,...



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
// Check if image file is a actual image or fake image
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
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
}

else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			if(mysqli_query($conn, $sql_3)!= null){
				var_dump(mysqli_query($conn, $sql_3));
				die();
					$pic_path  =	mysqli_query($conn, $sql_3);
				$path = mysqli_fetch_assoc($pic_path);
				$updateStatement ="UPDATE images SET path='$target_file' WHERE id=$uid";
				echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        $_db_host = "localhost";
        $_db_datenbank = "cshare";
        $_db_username = "root";
        $_db_passwort = "";
        $conn = new mysqli($_db_host, $_db_username, $_db_passwort, $_db_datenbank);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
				if ($_res = $conn->query($updateStatement)) {
            echo "<br>Image $target_file has been updated.";
        } else {
					var_dump($_res);
            echo "<br>NO insertion into database";
        }

        $imagefile = $target_file;
       // var_dump($imagefile); die();
        $imagesize = getimagesize($imagefile);
        $imagewidth = $imagesize[0];
        $imageheight = $imagesize[1];
        $imagetype = $imagesize[2];
        switch ($imagetype) {
                // Bedeutung von $imagetype:
                // Bedeutung von $imagetype:
                // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 =
                // TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15
                // = WBMP, 16 = XBM
            case 1: // GIF
                $image = imagecreatefromgif($imagefile);
                break;
            case 2: // JPEG
                $image = imagecreatefromjpeg($imagefile);
                break;
            case 3: // PNG
                $image = imagecreatefrompng($imagefile);
                break;
            default:
                die('Unsupported imageformat');
        }
        // Maximalausmaße
        $maxthumbwidth = 300;
        $maxthumbheight = 300;
        // Ausmaße kopieren, wir gehen zuerst davon aus, dass das Bild schon Thumbnailgröße hat
        $thumbwidth = $imagewidth;
        $thumbheight = $imageheight;
        // Breite skalieren falls nötig
        if ($thumbwidth > $maxthumbwidth) {
            $factor = $maxthumbwidth / $thumbwidth;
            $thumbwidth *= $factor;
            $thumbheight *= $factor;
        }
        // Höhe skalieren, falls nötig
        if ($thumbheight > $maxthumbheight) {
            $factor = $maxthumbheight / $thumbheight;
            $thumbwidth *= $factor;
            $thumbheight *= $factor;
        }
        // Thumbnail erstellen
        $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
        imagecopyresampled(
            $thumb,
            $image,
            0,
            0,
            0,
            0, // Startposition des Ausschnittes
            $thumbwidth,
            $thumbheight,
            $imagewidth,
            $imageheight
        );
       // header('Content-Type: image/png');


       // imagepng($thumb);

        // In Datei speichern
         $thumbfile = 'thumbs/' . basename($_FILES["fileToUpload"]["name"]);
        imagepng($thumb, $thumbfile);
        imagedestroy($thumb);
        # close database
        $conn->close();
			}
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        $_db_host = "localhost";
        $_db_datenbank = "cshare";
        $_db_username = "root";
        $_db_passwort = "";
        $conn = new mysqli($_db_host, $_db_username, $_db_passwort, $_db_datenbank);
        //Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $insertStatement = "INSERT INTO images (id, uid, path) VALUES ('',$uid,'$target_file');";
				var_dump($insertStatement);
        if ($_res = $conn->query($insertStatement)) {
            echo "<br>Image $target_file has been added to the database.";
							$pic_path  =	mysqli_query($conn, $sql_3);
							$path = mysqli_fetch_assoc($pic_path);
							var_dump($path);
        } else {
					var_dump($_res);
            echo "<br>NO insertion into database";
        }

        $imagefile = $target_file;
       // var_dump($imagefile); die();
        $imagesize = getimagesize($imagefile);
        $imagewidth = $imagesize[0];
        $imageheight = $imagesize[1];
        $imagetype = $imagesize[2];
        switch ($imagetype) {
                // Bedeutung von $imagetype:
                // Bedeutung von $imagetype:
                // 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP, 7 = TIFF(intel byte order), 8 =
                // TIFF(motorola byte order), 9 = JPC, 10 = JP2, 11 = JPX, 12 = JB2, 13 = SWC, 14 = IFF, 15
                // = WBMP, 16 = XBM
            case 1: // GIF
                $image = imagecreatefromgif($imagefile);
                break;
            case 2: // JPEG
                $image = imagecreatefromjpeg($imagefile);
                break;
            case 3: // PNG
                $image = imagecreatefrompng($imagefile);
                break;
            default:
                die('Unsupported imageformat');
        }
        // Maximalausmaße
        $maxthumbwidth = 300;
        $maxthumbheight = 300;
        // Ausmaße kopieren, wir gehen zuerst davon aus, dass das Bild schon Thumbnailgröße hat
        $thumbwidth = $imagewidth;
        $thumbheight = $imageheight;
        // Breite skalieren falls nötig
        if ($thumbwidth > $maxthumbwidth) {
            $factor = $maxthumbwidth / $thumbwidth;
            $thumbwidth *= $factor;
            $thumbheight *= $factor;
        }
        // Höhe skalieren, falls nötig
        if ($thumbheight > $maxthumbheight) {
            $factor = $maxthumbheight / $thumbheight;
            $thumbwidth *= $factor;
            $thumbheight *= $factor;
        }
        // Thumbnail erstellen
        $thumb = imagecreatetruecolor($thumbwidth, $thumbheight);
        imagecopyresampled(
            $thumb,
            $image,
            0,
            0,
            0,
            0, // Startposition des Ausschnittes
            $thumbwidth,
            $thumbheight,
            $imagewidth,
            $imageheight
        );
       // header('Content-Type: image/png');


       // imagepng($thumb);

        // In Datei speichern
         $thumbfile = 'thumbs/' . basename($_FILES["fileToUpload"]["name"]);
        imagepng($thumb, $thumbfile);
        imagedestroy($thumb);
        # close database
        $conn->close();
    }
}
?>

</html>
