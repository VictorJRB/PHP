<?php
session_start();

if (!isset($_SESSION['logeado'])) {
    //echo "No tienes permiso para ver la pagina</br>";
    // echo "<h2><a href='login.php'>Logeate</a></h2>";

    header("location: login.php");

    exit;
}

require_once "funciones.php";
require_once "config.php";
cabecera("Planos", "<img src=''>");
?>
<!DOCTYPE html>
<html>
<head>
    <script src="JS/jquery.min.js"></script>

    <style>
        #grande {
            float:right;
            width:86%;
            height: 57%;
            margin-left: 12%;
        }

        #peque{
            float:left;
            width: 16%;
            border: 1px solid;
            margin-top: -540px;
            height: 100%;


        }
        #container {
            width:90%;
            height:1000px;
            margin-left:5%;
            overflow: hidden;
        }
        body {
            background-color: cornflowerblue;
        }
    </style>


    <script>
        $(document).ready(function(){
            $("#foto4").click(function(){
                $("#foto1").fadeIn("slow");
                $("#foto2").fadeOut("slow");
                $("#foto3").fadeOut("slow");
                $("#foto8").fadeOut("slow");
            });
            $("#foto5").click(function(){
                $("#foto2").fadeIn("slow");
                $("#foto1").fadeOut("slow");
                $("#foto3").fadeOut("slow");
                $("#foto8").fadeOut("slow");
            });
            $("#foto6").click(function(){
                $("#foto3").fadeIn("slow");
                $("#foto2").fadeOut("slow");
                $("#foto1").fadeOut("slow");
                $("#foto8").fadeOut("slow");
            });
            $("#foto7").click(function(){
                $("#foto8").fadeIn("slow");
                $("#foto2").fadeOut("slow");
                $("#foto1").fadeOut("slow");
                $("#foto3").fadeOut("slow");
            });
        });
    </script>
</head>
<body>
<input  onClick="javascript:window.history.back();" style="float: right;" class="btn btn-info" name="Submit" value="VOLVER" />


<div id="container">
    <div id="grande">
        <img id="foto1" src="imagenes/planos/1.jpg" style="width:950px; height: 600px; margin-left: 4%; margin-top: 12%;" alt="..." >
        <img id="foto2" src="imagenes/planos/2.jpg" style="width:980px; height:600px; margin-left: 3.1%; margin-top: 12%; alt="..." >
        <img id="foto3" src="imagenes/planos/altair.jpg" style="width:950px; height: 600px; margin-left: 4%; margin-top: 7%;" alt="..." >
        <img id="foto8" src="imagenes/planos/ezioaltair.jpg" style="width:950px; height: 600px; margin-left: 4%; margin-top: 7%;" alt="..." >
    </div>
    <div id="peque">
        <br>
        <div>
            <p style="text-align: center; color:white;">AC EMPIRE</p><img id="foto4" src="imagenes/planos/1.jpg" width="100%" height="100%" style="" alt="...">
        </div><br><br>
        <div>
            <p style="text-align: center; color:white;">AC PELÍCULA</p><img id="foto5" src="imagenes/planos/2.jpg" width="100%" height="100%" style="" alt="...">
        </div><br><br>
        <div>
            <p style="text-align: center; color:white;">ALTAIR</p><img id="foto6" src="imagenes/planos/altair.jpg" width="100%" height="100%" style="" alt="...">
        </div><br><br>
        <div>
            <p style="text-align: center; color:white;">EZIO/ALTAIR</p><img id="foto7" src="imagenes/planos/ezioaltair.jpg" width="100%" height="100%" style="" alt="...">
        </div>
    </div>

</div>


</body>
</html>