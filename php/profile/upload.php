<?php
session_start();
include_once '../db_connect.php';
$id = $_SESSION['id'];

if(isset($_POST['upload_submit'])){
    if (empty($_FILES['file'])) {
        exit('Empty File');
     }
    $file= $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmp = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $filesError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.',$_FILES['file']['name']);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg','jpeg','png','pdf');
    if(in_array($fileActualExt,$allowed)){
        if($_FILES['file']['error'] ===  0){
            if($_FILES['file']['size'] < 1000000){            
                $fileNameNew = "profile".$id.".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($_FILES['file']['tmp_name'],$fileDestination);
                $sql = "UPDATE profileimg SET status = 0 WHERE userid ='$id';";
                $result = mysqli_query($conn, $sql);
                header("Location: index.php?uploadsucess");
            }else{
                echo "Your file is too big!";
            }
        }else{
            echo "You have an error uploading your file!";
        }
    }else{
        echo "You cannot upload files of this type!";
    }

}
