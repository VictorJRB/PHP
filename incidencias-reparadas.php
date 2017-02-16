
<?php
require_once "funciones.php";
require_once "config.php";
cabecera("Incidencias Reparadas", "<img src=''> ");


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

    //$sql= "SELECT historial_prestamo.*, usuarios.nombre as usuario,
         //  from historial_prestamo LEFT JOIN usuarios ON historial_prestamo.id_usuario=usuarios.id";



if ($_SESSION['perfil'] != "Administrador" || $_SESSION['perfil'] != "Usuario") {

if(isset ($_SESSION['id']) && is_numeric($_SESSION['id'])) {


   // $sql= "SELECT * from informe_incidencia";

    $sql= "SELECT incidencia_reparada.*, usuarios.usuario as id_tecnico, planta.nombre as id_planta, zona.nombre as id_zona, modulo.nombre as id_modulo, incidencia.nombre as id_incidencia
           from incidencia_reparada LEFT JOIN usuarios ON incidencia_reparada.id_tecnico=usuarios.id LEFT JOIN planta ON incidencia_reparada.id_planta=planta.id
           LEFT JOIN zona ON incidencia_reparada.id_zona=zona.id LEFT JOIN modulo ON incidencia_reparada.id_modulo=modulo.id
           LEFT JOIN incidencia ON incidencia_reparada.id_incidencia=incidencia.id order by fecha_arreglo desc";
}}


    if (isset($_GET['accion']))
        if ($_GET['accion'] == "ordenar")
            $sql = 'SELECT * FROM incidencia_reparada ORDER BY '.$_GET['parametro'];
        else if ($_GET['accion'] == "buscar") {
            $sql = "SELECT * FROM incidencia_reparada where ".$_GET['campo']." LIKE '%".$_GET['valor']."%'";
        }


    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    ?>
    <a style="float: right; margin-top: 1.2%;" href="logout.php" class="btn btn-info">CERRAR SESION</a>
    <a href="index.php" style="float: left;  margin-top: 1.2%; margin-right: 1%;" class="btn btn-info">VOLVER</a>
    <div style="font-style: italic; height: 58px; width: 1160px; "><h3 style="float: right; margin-right: 1%; color: white; font-size:30px;"> <?php echo $_SESSION['nombre']?></h3></div>
    <div style="font-style: italic; height: 58px; width: 1400px; "><h3 style="float:left; margin-top:60px; margin-left:20px; color: silver; font-size: 18px;">REPARADAS</h3></div>


    </form>


    <?php


    # Leemos los datos del recordset con el método ->fetch()
    echo "<table class='table table-striped table-bordered text-center' style='background-color: lightsteelblue; margin-left: 0.8%; text-align: center; font-weight: 600;'>";
    echo "<tr>";
    echo "<th style='text-align: center;'>Opciones</th>";
    echo "<th style='text-align: center;'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>Id</a></th>";
   // echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=id_libro'>Id del Libro</a></th>";
    //echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=categoria'>Categoría</a></th>";
    echo "<th style='text-align: center;'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_planta'>Planta</a></th>";
    echo "<th style='text-align: center;'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_zona'>Zona</a></th>";
    echo "<th style='text-align: center;'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_modulo'>Módulo</a></th>";
    echo "<th style='text-align: center;'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=fecha'>Fecha de Creación</a></th>";
    echo "<th style='text-align: center;'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=fecha'>Fecha de reparación</a></th>";
    echo "<th style='text-align: center;'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=hora'>Hora de reparación</a></th>";
    echo "<th style='text-align: center;'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id_incidencia'>Incidencia</a></th>";
    echo "<th style='text-align: center;'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id_incidencia'>Creado</a></th>";
    echo "<th style='text-align: center;'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id_incidencia'>Eliminado</a></th>";
    echo "</tr>";

    while ($row = $stmt->fetch()) {
        echo "<tr>";
        if ($_SESSION['perfil'] == "Administrador") {
            echo '<td>
            <a href="preguntaborrar3.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash " aria-hidden="true"></span>
            </a>
            <a href="verinci-reparada.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open " aria-hidden="true"></span>
            </a>
        </td>';
        }
        else {
            echo '<td>
            <a href="verinci-reparada.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open " aria-hidden="true"></span>
            </a>
        </td>';
        }
        echo "<td>".$row['id']. " </td> ";
        //   echo "<td>".$row['id_libro']. " </td> ";
        echo "<td>".$row['id_planta'] . "</td>";
        // echo "<td>".$row['categoria'] . " </td> ";
        // echo "<td>".$row['editorial'] . "</td>";
        echo "<td>".$row['id_zona'] . "</td>";
        echo "<td>".$row['id_modulo'] . "</td>";
        echo "<td>".$row['fecha'] . "</td>";
        echo "<td>".$row['fecha_arreglo'] . "</td>";
        echo "<td>".$row['hora_arreglo'] . "</td>";
        echo "<td>".$row['id_incidencia'] . "</td>";
        echo "<td>".$row['id_tecnico'] . "</td>";
        echo "<td>".$row['tecnico_borro'] . "</td>";
        echo "</tr>";
    }


    # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
} catch (PDOException $err) {
    // Mostramos un mensaje genérico de error.
    echo "Error: ejecutando consulta SQL.";

}
?>
<?php
    pie()
?>




