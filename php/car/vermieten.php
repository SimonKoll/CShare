<!DOCTYPE html>
<html>

<head>
    <title>Informations about your car</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <script src='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.4.1/mapbox-gl.css' rel='stylesheet' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
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
    ?>

<body>
    <div class="container">

        <h4>Please specify your car</h4>
        <p align="right">Hi -<?php echo $row_1["username"] ?> - <a href="../login/logout.php">Logout</a></p>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <a href="../index/index.php"><button type="button" class="btn btn-outline-primary">INDEX</button></a><br>
                </div>
                <div class="col-sm-4"><a href="../chat/index.php"><button type="button" class="btn btn-outline-primary">CHAT</button></a><br>
                </div>
                <div class="col-sm-4"><a href="../map/map.php"><button type="button" class="btn btn-outline-primary">MAP</button></a><br>
                </div>
            </div>
        </div>
        <select id="brand" style="width: 100%;padding: 16px 20px; border: none; border-radius: 4px; background-color: #87cefa;" onchange="$.ajax({
    type: 'POST',
    url: 'vermieten.php',
    data:{value: this.value}})">
            <?php
            $sql1 = "SELECT brand, count(*) FROM cars.cars GROUP BY brand";

            $brand = mysqli_query($conn, $sql1);

            if (mysqli_num_rows($brand) > 0) {
                while ($row = mysqli_fetch_assoc($brand)) {
                    echo "<option value=" . $row["brand"] . ">" . $row["brand"] . "</option>";
                }
            } ?>
        </select>
        <br>

        <br>
        <select id="model" style="width: 100%;padding: 16px 20px; border: none; border-radius: 4px; background-color: #87cefa;
    "></select>
        <br>
        <div class="container"></div>

        <div class="container_adr"></div>
        <div id="result"></div>
        <script>
            $(document).ready(function() {
                $("#brand").change(function() {
                    var val_brand = $(this).val();
                    $.ajax({
                        url: "./choosecar.php",
                        type: "post",
                        data: val_brand,
                        success: function(response) {
                            model = document.getElementById('model');
                            $(model).html(response);

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                });
                $("#model").change(function() {
                    var cont = document.getElementsByClassName("container_adr");
                    var form = '        <h3 align="center">Where is your car?</h3><br /><br /><div class="panel panel-default"><div class="panel-heading">Enter adress:</div><div class="panel-body"><form method="post">    </p>      <div class="form-group"><label>Zip Code </label> <input type="number" name="zip" class="form-control" required />      </div>      <div class="form-group">          <label>Town</label>          <input type="text" name="town" class="form-control" required />        </div>    <div class="form-group">          <label>Street</label>          <input type="text" name="street" class="form-control" required />        </div>        <div class="form-group">            <button type="button" id="checkbtn" class="btn btn-info" onClick="apicall();">test</button>  </form>       </div>    </div>';
                    $(cont).html(form);

                });

            });
            var apicall = function() {
                var form = $('form').serialize();
                var brand = $('#brand').val();
                var model = $('#model').val();
                $.ajax({
                    type: 'POST',
                    url: './checkinsert.php',
                    data: {
                        form,
                        brand,
                        model
                    },
                    success: function(response) {
                        result = document.getElementById('result');
                        $(result).html(response);

                    },
                    error: function(x) {
                        alert(error);
                    }
                });
            }
        </script>
</body>

</html>
