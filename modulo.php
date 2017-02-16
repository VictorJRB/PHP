
<?php
require_once "funciones.php";
require_once "config.php";
cabecera("Módulos","<img src=''> ");

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

if ($_SESSION['perfil'] != "Administrador") {
    echo "<h1 class='container text-center'>NO TIENES PERMISO PARA VER LA PÁGINA</h1>";
    exit;
}
//if ($_SESSION['perfil'] != "Administrador" && $_SESSION['perfil'] != "Bibliotecario") {
 //   echo "<h1 class='container text-center'>NO TIENES PERMISO PARA VER LA PÁGINA</h1>";
//    exit;
//}

//$editorial=$_POST['id_editorial'];
//$categoria=$_POST['id_categoria'];


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



if ($_SESSION['perfil'] != "Administrador") {

if(isset ($_SESSION['id']) && is_numeric($_SESSION['id'])) {

    //$sql= "SELECT * from prestamos WHERE id = ".$_SESSION['id'];
    $sql= "SELECT historial_prestamo.*, libros.nombre as nombre, usuarios.usuario as usuario
           from historial_prestamo LEFT JOIN libros ON historial_prestamo.id_libro=libros.id LEFT JOIN usuarios ON historial_prestamo.id_usuario=usuarios.id HAVING id_usuario = ".$_SESSION['id'];
}
} else {

    $sql= "SELECT modulo.*, zona.nombre as id_zona
           from modulo LEFT JOIN zona ON modulo.id_zona=zona.id";
    }

    //$sql= "SELECT * FROM historial_prestamo";




    if (isset($_GET['accion']))
        if ($_GET['accion'] == "ordenar")
            $sql = 'SELECT * from modulo ORDER BY '.$_GET['parametro'];
        else if ($_GET['accion'] == "buscar") {
            $sql = "SELECT * from modulo where ".$_GET['campo']." LIKE '%".$_GET['valor']."%'";
        }


    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    </br>
    <a style="float: right; margin-top: 1.2%;" href="logout.php" class="btn btn-info">CERRAR SESION</a>
    <div style="font-style: italic; height: 58px; width: 1160px; "><h3 style="float: right; margin-right: 1%; color: white;"> <?php echo $_SESSION['nombre']?></h3>
        <a href="nuevomodulo.php" style=" margin-top: 1.2%; margin-left: 1%;" class="btn btn-info">NUEVO MODULO</a>
        <a href="index.php" style="float: left; margin-left: 1%;  margin-top: 1.2%" class="btn btn-info">VOLVER</a>
    </div>

    <form action="modulo.php" method="get" style=" height: 58px; width: 1160px;">
        <input type="hidden" name="accion" value="buscar">
        <select style="margin-top: 1.5%; margin-left: 1.5%;" name="campo">
            <option value="id">Id</option>
            <option value="nombre">Módulo</option>
        </select>

        <input type="text" name="valor" value="">
        <input type="submit" name="buscar" value="Buscar">


    </form>


    <?php

    echo "</br>";

    # Leemos los datos del recordset con el método ->fetch()
    echo "<table class='table table-striped table-bordered' style='background-color: lightsteelblue; margin-left: 0.8%;'>";
    echo "<tr>";
    echo "<th style='text-align: center;'>Opciones</th>";
    echo "<th style='text-align: center;'><a href='zona.php?accion=ordenar&parametro=id'>Id</a></th>";
   // echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=id_libro'>Id del Libro</a></th>";
    echo "<th style='text-align: center;'><a href='zona.php?accion=ordenar&parametro=nombre'>Módulo</a></th>";
    //echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=categoria'>Categoría</a></th>";
    echo "<th style='text-align: center;'><a href='zona.php?accion=ordenar&parametro=autor'>Zona</a></th>";
    echo "</tr>";

    while ($row = $stmt->fetch()) {
        echo "<tr style='font-weight: 600;'>"; echo '<td>
            <a href="preguntaborrar6.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>&nbsp &nbsp &nbsp &nbsp &nbsp
             <a href="modificarmodulo.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>
        </td>';
        echo "<td>".$row['id']. " </td> ";
        echo "<td>".$row['nombre'] . " </td> ";
        echo "<td>".$row['id_zona'] . "</td>";
        echo"</tr>";
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
