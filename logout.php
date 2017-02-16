<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Salir</title>
        <link rel="shortcut icon" href=imagenes/modulo/favicon type="image/x-icon"/>
		<meta charset="UTF-8">
		<meta name=description content="">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body>

    <?php
    session_start();

    require_once "funciones.php";
    require_once "config.php";
    cabecera("Biblioteca - Login", "<img src=''>");

    if (!isset($_SESSION['logeado'])) {
        //echo "No tienes permiso para ver la pagina</br>";
        // echo "<h2><a href='login.php'>Logeate</a></h2>";


        header("location: login.php");

        exit;
    }

    $_SESSION=array();

    session_destroy();

    ?>


<br><br>
		<h1 class="text-center" style="color: white;">Salir</h1>


        <h2 style="color: white;">Se ha desconectado correctamente</h2>

        <a href="index.php" class="btn btn-info">IR A INICIO</a>

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	</body>
</html>