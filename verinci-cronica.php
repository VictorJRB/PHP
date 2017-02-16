
<?php
require_once "funciones.php";
require_once "config.php";
cabecera("Ver Incidencia Crónica", "<img src=''>");
# Conectamos a la base de datos
//$host='localhost';
//$dbname='agenda';
//$user='agenda';
//$pass='agenda';

session_start();

if (!isset($_SESSION['logeado'])) {
    //echo "No tienes permiso para ver la pagina</br>";
    // echo "<h2><a href='login.php'>Logeate</a></h2>";


    header("location: login.php");

    exit;
}

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

}
catch(PDOException $e) {
    echo "Se ha producido un error al intentar conectar al servidor MySQL: ".$e->getMessage();
}


try {
    if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

       //$sql= "SELECT * from libros WHERE id = ".$_GET['id'];
        $sql= "SELECT incidencia_cronica.*, usuarios.nombre as id_tecnico, planta.nombre as id_planta, zona.nombre as id_zona, modulo.nombre as id_modulo, incidencia.nombre as id_incidencia
           from incidencia_cronica LEFT JOIN usuarios ON incidencia_cronica.id_tecnico=usuarios.id LEFT JOIN planta ON incidencia_cronica.id_planta=planta.id
           LEFT JOIN zona ON incidencia_cronica.id_zona=zona.id LEFT JOIN modulo ON incidencia_cronica.id_modulo=modulo.id
           LEFT JOIN incidencia ON incidencia_cronica.id_incidencia=incidencia.id
           HAVING id = ".$_GET['id'];

        //$sql2="SELECT * from historial_prestamo";


    $stmt = $pdo->query($sql);
   // $stmt = $pdo->query($sql2);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

     $row = $stmt->fetch();
        echo "<table class='table table-striped table-bordered' style='background-color: lightsteelblue; margin-top: 5;'>";
        echo "<tr>";
       // echo "<td style='background-color: lightgray;' class='text-center'><img src='imagenes/libros/".$row['imagen'] . "' alt='Imagen del libro' width='120'></td>"."";
        echo "<td colspan='1' style='background-color:silver; color:white;'><b>ID:</b> ".$row['id']."</td>". "</br>";
        echo "</tr>";
        echo "<tr  class='text-center'>";
        echo "<td><b>Técnico</b></br> ".$row['id_tecnico']."</td>". "</br>";
        echo "<td><b>Planta</b> </br>".$row['id_planta']."</td>". "</br>";
        echo "<td><b>Zona</b></br> ".$row['id_zona']."</td>". "</br>";
        echo "<td><b>Módulo</b></br> ".$row['id_modulo']."</td>". "</br>";
        echo "<td><b>Fecha</b></br> ".$row['fecha']."</td>". "</br>";
        echo "<td><b>Incidencia</b></br> ".$row['id_incidencia']."</td>". "</br>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='background-color:white; height:80px; background-color:silver; color:white;'><b>Observación:</b>".nl2br($row['observacion'])."</td>". "</br>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2'  style='background-color:white; height:150px; background-color:silver; color:white;'><b>Historial:</b> ".nl2br($row['historial'])."</td>". "</br>";
        echo "</tr>";
        echo "</table>";


    # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;

        echo "&nbsp<a href='incidencias-cronicas.php' class='btn btn-info'>VOLVER</a>";

    } else
        echo "Datos incorrectos";


} catch (PDOException $err) {
    // Mostramos un mensaje genérico de error.
    echo "Error: ejecutando consulta SQL.";
}


?>




<?php pie() ?>