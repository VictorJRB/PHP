
<?php
require_once "funciones-fondo.php";
require_once "config.php";
cabecera("Mi página","<img src=''> ");

session_start();

if (!isset($_SESSION['logeado'])) {
    //echo "No tienes permiso para ver la pagina</br>";
    // echo "<h2><a href='login.php'>Logeate</a></h2>";

    header("location: login.php");

    exit;
}

?>

    </br>

<a style="float: right; margin-top: 15%; margin-right: 6%" href="logout.php" class="btn btn-info">CERRAR SESION</a>
<div class="text-center" style="font-style: italic; height: 58px; width: 1168px; "><h3  style=" margin-right: 35%; margin-top:9.5% ; color:white; font-size: 38px;"> <?php echo $_SESSION['nombre']?></h3></div>



    <div class="text-center row" style=" margin-top: 15%; width:110%;"><a href="incidencias.php" class="btn btn-info " style="font-size: 20px;">Crear Incidencia</a>&nbsp &nbsp &nbsp
		<a href="incidencias-generales.php" class="btn btn-info " style="font-size: 20px;">Ver Incidencias</a>&nbsp &nbsp &nbsp
		<a href="incidencias-reparadas.php" class="btn btn-info " style="font-size: 20px;">Incidencias Reparadas</a>&nbsp &nbsp &nbsp
        <a href="incidencias-cronicas.php" class="btn btn-info  " style="font-size: 20px; text-align: center;">Incidencias Crónicas</a>&nbsp &nbsp &nbsp
		<a href="planos.php" class="btn btn-info  " style="font-size: 20px;">Planos</a>
    </div>

    <?php
    if ($_SESSION['perfil'] == "Administrador") {

    echo '<div class="text-center row" style="margin-top: 10%; "><a href="usuarios.php" class="btn btn-info " style="font-size: 20px">Ver/Crear Usuarios</a> &nbsp &nbsp &nbsp';
        echo '<a href="zona.php" class="btn btn-info " style="font-size: 20px">Zonas</a>&nbsp &nbsp &nbsp ';
    echo '<a href="modulo.php" class="btn btn-info " style="font-size: 20px">Módulos</a></div>';
    }
    else {
        echo '';
    }
    ?>







<div class="container">
<?php
pie()
?>
</div>