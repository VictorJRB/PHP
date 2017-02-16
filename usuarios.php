
<?php

require_once "funciones.php";
require_once "config.php";
cabecera("Usuarios", "<img src=''>");
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
           echo "<h1 class='container text-center' style='color:white'>NO TIENES PERMISO PARA VER LA PÁGINA</h1>";
           exit;
       }


try {
    $pdo = new PDO("mysql:host=$servidor; dbname=$bbdd", $usuario, $clave);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

}
catch(PDOException $e) {
    echo "Se ha producido un error al intentar conectar al servidor MySQL: ".$e->getMessage();
}


try {


   // $sql= "SELECT contactos.*, grupos.nombre as grupo
    //       from contactos LEFT JOIN grupos ON contactos.idgrupo=grupos.id ";

    $sql= "SELECT * from usuarios";

    if (isset($_GET['accion']))
        if ($_GET['accion'] == "ordenar")
            $sql = 'SELECT * from usuarios ORDER BY '.$_GET['parametro'];
        else if ($_GET['accion'] == "buscar") {
            $sql = "SELECT * from usuarios where ".$_GET['campo']." LIKE '%".$_GET['valor']."%'";
        }


    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
?>
    </br>
    <a href="nuevousuario.php" class="btn btn-info">NUEVO</a>
    <a href="index.php" style="float: right; margin-right: 1%;" class="btn btn-info">VOLVER</a>
    <form action="usuarios.php" method="get">
        <input type="hidden" name="accion" value="buscar">
        <select name="campo">
            <option value="id">Id</option>
            <option value="nombre">Nombre</option>
            <option value="usuario">Usuario</option>
            <option value="perfil">Perfil</option>
        </select>

        <input type="text" name="valor" value="">
        <input type="submit" name="buscar" value="Buscar">

    </form><br>


<?php

    # Leemos los datos del recordset con el método ->fetch()
    echo "<table style=' background-color: silver;' class='table table-bordered'>";
    echo "<tr>";
    echo "<th>Opciones</th>";
    echo "<th><a href='usuarios.php?accion=ordenar&parametro=id'>Id</a></th>";
    echo "<th><a href='usuarios.php?accion=ordenar&parametro=usuario'>Usuario</a></th>";
    echo "<th><a href='usuarios.php?accion=ordenar&parametro=nombre'>Nombre</a></th>";
    echo "<th><a href='usuarios.php?accion=ordenar&parametro=perfil'>Perfil</a></th>";
    echo "</tr>";

    while ($row = $stmt->fetch()) {
        echo "<tr>";
        echo '<td>
             <a href="modificarusuario.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>
            </a>

              <a style="margin-left:8%;" href="modificarpass.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span>
            </a>
        </td>';
        echo "<td>".$row['id']. " </td> ";
        echo "<td>".$row['usuario'] . " </td> ";
         echo "<td>".$row['nombre'] . "</td>";
        echo "<td>".$row['perfil'] . "</td>";
        echo "</tr>";
    }

    # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
} catch (PDOException $err) {
    // Mostramos un mensaje genérico de error.
    echo "Error: ejecutando consulta SQL.";
}

pie()
?>

