<?php
require_once "funciones.php";
require_once "config.php";
cabecera("Borrar Incidencia", "<img class=text-center src=''> ");


session_start();

if (!isset($_SESSION['logeado'])) {
    //echo "No tienes permiso para ver la pagina</br>";
    // echo "<h2><a href='login.php'>Logeate</a></h2>";

    header("location: login.php");

    exit;
}


//if ($_SESSION['perfil'] != "Administrador" && $_SESSION['perfil'] != "Bibliotecario") {
//   echo "<h1 class='container text-center'>NO TIENES PERMISO PARA VER LA PÁGINA</h1>";
//    exit;
//}



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
    $sql= "SELECT informe_incidencia.*, usuarios.nombre as id_tecnico, planta.nombre as id_planta, zona.nombre as id_zona, modulo.nombre as id_modulo, subincidencia.nombre as id_subincidencia, incidencia.nombre as id_incidencia
           from informe_incidencia LEFT JOIN usuarios ON informe_incidencia.id_tecnico=usuarios.id LEFT JOIN planta ON informe_incidencia.id_planta=planta.id
           LEFT JOIN zona ON informe_incidencia.id_zona=zona.id LEFT JOIN modulo ON informe_incidencia.id_modulo=modulo.id
           LEFT JOIN subincidencia ON informe_incidencia.id_subincidencia=subincidencia.id
           LEFT JOIN incidencia ON informe_incidencia.id_incidencia=incidencia.id
           HAVING id = ".$_GET['id'];

    //$sql2="SELECT * from historial_prestamo";


    $stmt = $pdo->query($sql);
    // $stmt = $pdo->query($sql2);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
}

   // $stmt = $pdo->query($sql);
    //$stmt->setFetchMode(PDO::FETCH_ASSOC);

    ?>



    <?php


    while ($row = $stmt->fetch()) {
    echo "<div><h2 style='color: white; text-align: center;'>¿Estás seguro/a de que quieres borrar esta incidencia del módulo ".$row['id_modulo'] ."?</h2></div>";
            echo '
            <a class="btn btn-info" style="margin-left:45%; margin-top:10%; font-size:20px;" href="borrarincidencia.php?id='.$row['id'].'">
               Si
             </a>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp';
        }



    # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
} catch (PDOException $err) {
    // Mostramos un mensaje genérico de error.
    echo "Error: ejecutando consulta SQL.";

}
?>
<a style="margin-top: 10%; font-size:20px;" href="incidencias-generales.php" class="btn btn-info">No</a>
<?php
pie()
?>




