<!DOCTYPE html>
<html>

<head>
    <title>The locations</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <!--  <script src="https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-FxwOM-OmMKsSTAEGa1m-6WlBGPTB0kI&callback=initMap"
  type="text/javascript"></script>

    <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
    <style>
        html,
        body,
        #map {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        ;
    </style>
    <meta charset="utf-8">
</head>
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

<body onload="getLocation()">

    <p align="right">Hi -<?php echo $row_1["username"] ?> - <a href="../login/logout.php">Logout</a></p>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-sm-4"><a href="../chat/index.php"><button type="button" class="btn btn-outline-primary">CHAT</button></a><br>
                </div>
                <div class="col-sm-4">
                    <a href="../car/vermieten.php"><button type="button" class="btn btn-outline-primary">RENT</button></a><br>
                </div>
                <div class="col-sm-4">
                    <a href="../index/index.php"><button type="button" class="btn btn-outline-primary">INDEX</button></a><br></div>
            </div>
        </div>
    </div>
    <div id='map' style='width: 90vw; height:90vh; margin-left:5vw;'></div>
    <!--  <div id="menu" style="width: 20vw; height:90vh; background-color:black;margin-top:5vh;"></div> -->


</body>
<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        //Google maps API initialisation
        var element = document.getElementById("map");
        var mapTypeIds = [];
        for (var type in google.maps.MapTypeId) {
            mapTypeIds.push(google.maps.MapTypeId[type]);
        }
        mapTypeIds.push("OSM");
        var map = new google.maps.Map(element, {
            center: new google.maps.LatLng(lat, lng),
            zoom: 16,
            mapTypeId: "OSM",
            mapTypeControlOptions: {
                mapTypeIds: mapTypeIds
            },
            streetViewControl: true
        });

        //Define OSM map type pointing at the OpenStreetMap tile server
        map.mapTypes.set("OSM", new google.maps.ImageMapType({
            getTileUrl: function(coord, zoom) {
                return "https://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
            },
            tileSize: new google.maps.Size(256, 256),
            name: "OpenStreetMap",
            maxZoom: 18
        }));

    }

    // Add geolocate control to the map.
</script>

</html>
