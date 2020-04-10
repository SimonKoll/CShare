<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php
    ob_start();
    session_start();
    if (isset($_SESSION['user_id'])) {
        session_destroy();
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        header("Location: ../../index.html");
    } else {
        header("Location: ../../index.html");
    }
    ?>
</body>

</html>
