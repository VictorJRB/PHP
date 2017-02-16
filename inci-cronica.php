
<?php
require_once "funciones.php";
require_once "config.php";
cabecera("Borrar Incidencia", "<img src=''>");
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
        $id=$_GET['id'];
        $stmt2 = $pdo->prepare('DELETE FROM informe_incidencia WHERE id = :id');
        $stmt = $pdo->prepare('INSERT INTO incidencia_cronica (id_planta, id_incidencia, id_zona, id_modulo, id_tecnico, fecha, historial, observacion) SELECT id_planta, id_incidencia, id_zona, id_modulo, id_tecnico, fecha, historial, observacion FROM informe_incidencia WHERE id = :id');
        $stmt->bindParam(':id', $id); // this time, we'll use the bindParam method
        $stmt->execute();
        $stmt2->bindParam(':id', $id); // this time, we'll use the bindParam method
        $stmt2->execute();

      // echo $stmt->rowCount(); // 1

        echo '<div class="alert alert-success" role="alert">Incidencia Crónica</div>';


        # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
    $stmt2 = null;

    } else
        echo '<div class="alert alert-danger" role="alert">Datos Incorrectos</div>';
} catch (PDOException $err) {
    // Mostramos un mensaje genérico de error.
    echo '<div class="alert alert-danger" role="alert">Error: ejecutando consulta SQL.</div>';


}


?>
<a href="incidencias-generales.php" class="btn btn-info">VOLVER</a>

<?php pie() ?>