
<?php
require_once "funciones.php";
require_once "config.php";
cabecera("Incidencias", "<img class=text-center src=''> ");


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

    //$sql= "SELECT historial_prestamo.*, usuarios.nombre as usuario,
         //  from historial_prestamo LEFT JOIN usuarios ON historial_prestamo.id_usuario=usuarios.id";



if ($_SESSION['perfil'] != "Administrador" || $_SESSION['perfil'] != "Usuario") {

if(isset ($_SESSION['id']) && is_numeric($_SESSION['id'])) {

   // $sql= "SELECT * from informe_incidencia";

    $sql= "SELECT informe_incidencia.*, planta.nombre as id_planta, usuarios.usuario as id_tecnico, zona.nombre as id_zona, modulo.nombre as id_modulo, subincidencia.nombre as id_subincidencia, incidencia.nombre as id_incidencia
           from informe_incidencia LEFT JOIN usuarios ON informe_incidencia.id_tecnico=usuarios.id LEFT JOIN planta ON informe_incidencia.id_planta=planta.id
           LEFT JOIN zona ON informe_incidencia.id_zona=zona.id LEFT JOIN modulo ON informe_incidencia.id_modulo=modulo.id
           LEFT JOIN subincidencia ON informe_incidencia.id_subincidencia=subincidencia.id
           LEFT JOIN incidencia ON informe_incidencia.id_incidencia=incidencia.id order by informe_incidencia.id_planta, informe_incidencia.id DESC ";
}}

    if (isset($_GET['accion']))
        if ($_GET['accion'] == "ordenar")
            $sql = 'SELECT informe_incidencia.*, planta.nombre as id_planta, usuarios.usuario as id_tecnico, zona.nombre as id_zona, modulo.nombre as id_modulo, subincidencia.nombre as id_subincidencia, incidencia.nombre as id_incidencia
           from informe_incidencia LEFT JOIN usuarios ON informe_incidencia.id_tecnico=usuarios.id LEFT JOIN planta ON informe_incidencia.id_planta=planta.id
           LEFT JOIN zona ON informe_incidencia.id_zona=zona.id LEFT JOIN modulo ON informe_incidencia.id_modulo=modulo.id
           LEFT JOIN subincidencia ON informe_incidencia.id_subincidencia=subincidencia.id
           LEFT JOIN incidencia ON informe_incidencia.id_incidencia=incidencia.id order by informe_incidencia.id_planta  ORDER BY '.$_GET['parametro'];

        else if ($_GET['accion'] == "buscar") {

                $sql = "SELECT informe_incidencia.* from informe_incidencia where ".$_GET['campo']." LIKE '%".$_GET['valor']."%'";
             $sql.= "SELECT informe_incidencia.*, planta.nombre as id_planta, usuarios.usuario as id_tecnico, zona.nombre as id_zona, modulo.nombre as id_modulo, subincidencia.nombre as id_subincidencia, incidencia.nombre as id_incidencia
           from informe_incidencia LEFT JOIN usuarios ON informe_incidencia.id_tecnico=usuarios.id LEFT JOIN planta ON informe_incidencia.id_planta=planta.id
           LEFT JOIN zona ON informe_incidencia.id_zona=zona.id LEFT JOIN modulo ON informe_incidencia.id_modulo=modulo.id
           LEFT JOIN subincidencia ON informe_incidencia.id_subincidencia=subincidencia.id
           LEFT JOIN incidencia ON informe_incidencia.id_incidencia=incidencia.id order by informe_incidencia.id_planta  where ".$_GET['campo']." LIKE '%".$_GET['valor']."%'";
            }

    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    ?>
    <a style="float: right; margin-top: 1.2%;" href="logout.php" class="btn btn-info">CERRAR SESION</a>
    <a href="index.php" style="float: left;  margin-top: 1.2%; margin-right: 1%;" class="btn btn-info">VOLVER</a>
    <a href="informe-pdf.php" style="float: left;  margin-top: 1.2%; margin-left: 1%;" class="btn btn-info">GUARDAR COMO PDF</a>
    <div style="font-style: italic; height: 58px; width: 1400px; "><h3 style="float: right; margin-right: 1%; color: white; font-size: 30px;"> <?php echo $_SESSION['nombre']?></h3></div>
    <div style="font-style: italic; height: 58px; width: 1400px; "><h3 style="float:left; margin-top:60px; margin-left:20px; color: silver; font-size: 18px;"> INCIDENCIAS</h3></div>



    <?php


    # Leemos los datos del recordset con el método ->fetch()
    echo "<table class='table table-striped table-bordered' style='background-color: lightsteelblue; margin-left: 0.8%; font-weight: 600; border: 2px black solid;'>";
    echo "<tr style='border: 2px black solid''>";
    if ($_SESSION['editar'] == "Si" || $_SESSION['ver'] == "Si" || $_SESSION['borrar'] == "Si"){

        echo "<th style='text-align: center; color: midnightblue; border: 2px black solid; width: 100px;'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>Opciones</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>H</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>P</a></th>";
        // echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=id_libro'>Id del Libro</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>Técnico</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>Id</a></th>";
        //echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=categoria'>Categoría</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_planta'>Planta</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_zona'>Zona</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_modulo'>Módulo/Pieza</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=fecha'>Fecha</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=hora'>Hora</a></th>";
        echo "<th style='text-align: center; border: 2px black solid' ><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id_incidencia'>Incidencia</a></th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_subincidencia'>Subincidencia</a></th>";
    }
    else {
    echo "<th style='text-align: center;'></th>";
   // echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=id_libro'>Id del Libro</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'>Técnico</th>";
        echo "<th style='text-align: center; border: 2px black solid'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id'>Id</a></th>";
    //echo "<th><a href='historialprestamo.php?accion=ordenar&parametro=categoria'>Categoría</a></th>";
    echo "<th style='text-align: center;border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_planta'>Planta</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_zona'>Zona</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_modulo'>Módulo/Pieza</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=fecha'>Fecha</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=hora'>Hora</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'><a href='../PHP-MUSEO/incidencias-generales.php?accion=ordenar&parametro=id_incidencia'>Incidencia</a></th>";
    echo "<th style='text-align: center; border: 2px black solid'><a href='../biblioteca/historialprestamo.php?accion=ordenar&parametro=id_subincidencia'>Subincidencia</a></th>";
    }
    echo "</tr>";

    while ($row = $stmt->fetch()) {
        echo "<tr height='20'>";


        if ($_SESSION['editar'] == "Si" && $_SESSION['ver'] == "No" && $_SESSION['borrar'] == "No"){
            echo '<td style="border: 1px black solid">
             <a href="modificarincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil " aria-hidden="true"></span>
            </a>
        </td>';

        }

        elseif ($_SESSION['perfil']=='Administrador') {
            echo '<td style="border: 1px black solid">
            <a href="modificarincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>
            <a href="verincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
             </a>
              <a href="preguntaborrar.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>
             <a href="preguntaborrar2.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
             </a>
        </td>';
        }

        elseif ($_SESSION['editar'] == "No" && $_SESSION['ver'] == "Si" && $_SESSION['borrar'] == "No") {
            echo '<td style="border: 1px black solid">
            <a href="verincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
             </a>
        </td>';
        }
        elseif ($_SESSION['editar'] == "No" && $_SESSION['ver'] == "No" && $_SESSION['borrar'] == "Si") {
            echo '<td style="border: 1px black solid">
            <a href="preguntaborrar.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>
        </td>';
        }
        elseif ($_SESSION['editar'] == "Si" && $_SESSION['ver'] == "Si" && $_SESSION['borrar'] == "No") {
            echo '<td style="border: 1px black solid">
            <a href="modificarincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>
            <a href="verincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
             </a>
        </td>';
        }
        elseif ($_SESSION['editar'] == "Si" && $_SESSION['ver'] == "No" && $_SESSION['borrar'] == "Si") {
            echo '<td style="border: 1px black solid">
            <a href="modificarincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>
            <a href="preguntaborrar.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>
        </td>';
        }

        elseif ($_SESSION['editar'] == "No" && $_SESSION['ver'] == "Si" && $_SESSION['borrar'] == "Si") {
            echo '<td style="border: 1px black solid">
            <a href="verincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
             </a>
            <a href="preguntaborrar.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>
        </td>';
        }
        elseif ($_SESSION['editar'] == "Si" && $_SESSION['ver'] == "Si" && $_SESSION['borrar'] == "Si") {
            echo '<td style="border: 1px black solid">
            <a href="modificarincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>
            <a href="verincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
             </a>
              <a href="preguntaborrar.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>
        </td>';
        }
        elseif ($_SESSION['perfil']=='Administrador') {
            echo '<td style="border: 1px black solid">
            <a href="modificarincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
             </a>
            <a href="verincidencia.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
             </a>
              <a href="preguntaborrar.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
             </a>
             <a href="preguntaborrar2.php?id='.$row['id'].'">
               <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
             </a>
        </td>';
        }
        else {
            echo '<td>

        </td>';


            echo '</tr>';
        }
        $fecha=date("Y-m-d");
        if ($row['fecha_fin'] >= $fecha ) {
        //   echo "<td>".$row['id_libro']. " </td> ";
            if ($row['historial']!= '') {
                echo '<td style="background-color: palegreen; border: 1px black solid;  color:grey; text-align:center;">H</td>';
            }
            else echo '<td style="border: 1px black solid; "></td>';
            if ($row['prioridad']== 'Si') {
                echo '<td class="parp" style="background-color: #ff4500; border: 1px black solid;  text-align:center; color:grey;">P</td>';
            }
            else echo '<td style="border: 1px black solid; "></td>';
        echo "<td height='20' style='border: 1px black solid; background-color:yellow;opacity:0.99; color:black; font-size:13px;'>".$row['id_tecnico'] . " </td> ";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99; color:black; font-size:12.5px'>".$row['id']. " </td> ";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99;  color:black; font-size:12.5px'>".$row['id_planta'] . "</td>";
        // echo "<td>".$row['categoria'] . " </td> ";
        // echo "<td>".$row['editorial'] . "</td>";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99; color:black; font-size:12.5px'>".$row['id_zona'] . "</td>";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99;  color:black; font-size:12.5px'>".$row['id_modulo'] . "</td>";
       // echo "<td style='border: 1px black solid'>".$row['fecha_fin'] . "</td>";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99;  color:black; font-size:12.5px'>".$row['fecha'] . "</td>";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99;color:black; font-size:12.5px'>".$row['hora'] . "</td>";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99; color:black; font-size:12.5px'>".$row['id_incidencia'] . "</td>";
        echo "<td style='border: 1px black solid; background-color:yellow;opacity:0.99; color:black;  font-size:12.5px'>".$row['id_subincidencia'] . "</td>";
        }
        elseif ($row['fecha_fin'] < $fecha && $fecha <= $row['fecha_fin_mes']) {
            if ($row['historial']!= '') {
                echo '<td style="background-color: palegreen; border: 1px black solid; text-align:center; color:grey;">H</td>';
            }
            else echo '<td style="border: 1px black solid; "></td>';
            if ($row['prioridad']== 'Si') {
                echo '<td class="parp" style="background-color: #ff4500; border: 1px black solid; text-align:center; color:grey;">P</td>';
            }
            else echo '<td style="border: 1px black solid; "></td>';
            //   echo "<td>".$row['id_libro']. " </td> ";
            echo "<td  style='border: 1px black solid; font-size:13px;'>".$row['id_tecnico'] . " </td> ";
            echo "<td style='border: 1px black solid; font-size:12.5px;'>".$row['id']. " </td> ";
            echo "<td style='border: 1px black solid; font-size:12.5px;'>".$row['id_planta'] . "</td>";
            // echo "<td>".$row['categoria'] . " </td> ";
            // echo "<td>".$row['editorial'] . "</td>";
            echo "<td style='border: 1px black solid; font-size:12.5px;'>".$row['id_zona'] . "</td>";
            echo "<td style='border: 1px black solid; font-size:12.5px; '>".$row['id_modulo'] . "</td>";
            // echo "<td style='border: 1px black solid'>".$row['fecha_fin'] . "</td>";
            echo "<td style='border: 1px black solid; font-size:12.5px;'>".$row['fecha'] . "</td>";
            echo "<td style='border: 1px black solid; font-size:12.5px;'>".$row['hora'] . "</td>";
            echo "<td style='border: 1px black solid; font-size:12.5px;'>".$row['id_incidencia'] . "</td>";
            echo "<td style='border: 1px black solid; font-size:12.5px; '>".$row['id_subincidencia'] . "</td>";
        }

        else {
            if ($row['historial']!= '') {
                echo '<td style="background-color: palegreen; border: 1px black solid; text-align:center; color:grey;">H</td>';
            }
            else echo '<td style="border: 1px black solid; "></td>';
            if ($row['prioridad']== 'Si') {
                echo '<td class="parp" style="background-color: #ff4500; border: 1px black solid; text-align:center; color:grey;">P</td>';
            }
            else echo '<td style="border: 1px black solid; "></td>';
            echo "<td style='border: 1px black solid;'>".$row['id_tecnico'] . " </td> ";
            echo "<td style='border: 1px black solid;'>".$row['id']. " </td> ";
            echo "<td style='border: 1px black solid;;'>".$row['id_planta'] . "</td>";
            // echo "<td>".$row['categoria'] . " </td> ";
            // echo "<td>".$row['editorial'] . "</td>";
            echo "<td style='border: 1px black solid;'>".$row['id_zona'] . "</td>";
            echo "<td style='border: 1px black solid;'>".$row['id_modulo'] . "</td>";
            // echo "<td style='border: 1px black solid'>".$row['fecha_fin'] . "</td>";
            echo "<td style='border: 1px black solid;'>".$row['fecha'] . "</td>";
            echo "<td style='border: 1px black solid;'>".$row['hora'] . "</td>";
            echo "<td style='border: 1px black solid;'>".$row['id_incidencia'] . "</td>";
            echo "<td style='border: 1px black solid;'>".$row['id_subincidencia'] . "</td>";
        }

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





