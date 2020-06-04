<!DOCTYPE html>

<html lang="en">

<head>
    <title>The locations</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <!--  <script src="https://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA-FxwOM-OmMKsSTAEGa1m-6WlBGPTB0kI&callback=initMap"
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

        #main {
            padding-right: 15px;
        }

        .infoWindow {
            width: 220px;
        }

        ;
    </style>
    <meta charset="utf-8">
</head>

<?php
    include_once("../db_connect.php");
    session_start();

    if (!isset($_SESSION['uid'])) {
        header("Location: ../login/login.php");
    }
    $uid = $_SESSION['user_id'];
    $sql_1 = "SELECT username FROM users WHERE uid=$uid";


    $uname =    mysqli_query($conn, $sql_1);

    $row_1 = mysqli_fetch_assoc($uname);

    //
    ?>

<script type="text/javascript">
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        var map;
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        var center = new google.maps.LatLng(lat, lng);
        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();

        init(center);
    }

    function init(center) {

        centerfromsho = center;
        var mapOptions = {
            zoom: 13,
            center: centerfromsho,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }

        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        var marker = new google.maps.Marker({
            position: center,
            map: map,
            title: 'Sie sind hier!',
            icon: {
                url: "../../img/logoC.png",
                scaledSize: new google.maps.Size(24, 24)
            }
        });
        makeRequest('get_locations.php', function(data) {

            var data = JSON.parse(data.responseText);

            for (var i = 0; i < data.length; i++) {
                displayLocation(data[i]);
            }
        });
    }


    function displayLocation(location) {
        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();

        var content = '<div class="infoWindow"><strong>' + location.name + '</strong>' +
            '<br/>' + location.address +
            '<br/>' + location.description +
            '<br/> <p> for more details contact </p> <strong>' + location.username + '</strong>'
        '</a></div>';

        if (parseInt(location.lat) == 0) {
            geocoder.geocode({
                'address': location.address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {

                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        title: location.name
                    });

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                    });
                }
            });
        } else {
            var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lon));
            var marker = new google.maps.Marker({
                map: map,
                position: position,
                title: location.name
            });

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.setContent(content);
                infowindow.open(map, marker);
            });
        }
    }

    function makeRequest(url, callback) {
        var request;
        if (window.XMLHttpRequest) {
            request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
        } else {
            request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
        }
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                callback(request);
            }
        }
        request.open("GET", url, true);
        request.send();
    }
</script>
</head>

<body onload="getLocation();">
    <p align="right">Hi -<?php echo $row_1["username"] ?> - <a
            href="../login/logout.php">Logout</a></p>
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-sm-4"><a href="../chat/index.php"><button type="button"
                            class="btn btn-outline-primary">CHAT</button></a><br>
                </div>
                <div class="col-sm-4">
                    <a href="../car/vermieten.php"><button type="button"
                            class="btn btn-outline-primary">RENT</button></a><br>
                </div>
                <div class="col-sm-4">
                    <a href="../index/index.php"><button type="button"
                            class="btn btn-outline-primary">INDEX</button></a><br></div>
            </div>
        </div>
    </div>
    <section id="main">
        <div id="map_canvas" style='width: 90vw; height:90vh; margin-left:5vw;'></div>
    </section>

</body>

</html>