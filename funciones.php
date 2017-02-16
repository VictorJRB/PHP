<?php

function pie( $pie="") {



?>


    </div>
    <div style="color:silver; opacity: 0.3; float: right; font-style: italic;"><h4>Incidencias 2.0</h4></div>
    </body>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

<?php
}
?>



<?php
 function cabecera ($titulo="Biblioteca", $encabezado="") {
     header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo $titulo ?></title>
    <link rel="shortcut icon" href=imagenes/planos/altair.jpg type="image/x-icon"/>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="ISO-8859-1">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">

    <script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
    <script>
        $(document).ready(parpadear);
        function parpadear(){ $('.parp').fadeIn(1000).delay(250).fadeOut(1000, parpadear) }

    </script>



</head>
<body onLoad="cambiar()"   style=" background: url('imagenes/modulo/altair2.jpg') no-repeat fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  ">
<div class="container" >
    <div class="text-center"><?php echo $encabezado ?></div>
</div><br><br><br>

<div style="margin-right: 3%; margin-left: 3%;">


<?php
}
?>


<?php
function conectaBaseDatos(){
    try{
        $servidor = "localhost";
        $bbdd = "incidencias";
        $puerto = "3306";
        $usuario = "root";
        $clave= "";

        $conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$bbdd",
            $usuario,
            $clave,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conexion;
    }
    catch (PDOException $e){
        die ("No se puede conectar a la base de datos". $e->getMessage());
    }
}


function damePlanta(){
    $resultado = false;
    $consulta = "SELECT * FROM planta";

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }

    return $resultado;
}

function dameIncidencia(){
    $resultado = false;
    $consulta = "SELECT * FROM incidencia";

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }

    return $resultado;
}
?>