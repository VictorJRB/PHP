<?php
require_once ("funciones3.php");
if(isset($_POST['incidencia'])){

    $subincidencia = dameSub($_POST['incidencia']);

    $html = "<option style='background-color: #808080; color:white' value=''>- Seleccione una Subincidencia -</option>";
    foreach($subincidencia as $indice => $registro){
        $html .= "<option style='background-color: #808080; color:white' value='".$registro['id']."'>".$registro['nombre']."</option>";
    }

    $respuesta = array("html"=>$html);
    echo json_encode($respuesta);
}


?>