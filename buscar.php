<?php
require_once ("funciones2.php");
cabecera("");
if(isset($_POST['planta'])){

    $zona = dameZona($_POST['planta']);

    $html = "<option style='background-color: #808080; color:white' value=''>- Seleccione una zona -</option>";
    foreach($zona as $indice => $registro){
        $html .= "<option value='".$registro['id']."'>".$registro['nombre']."</option>";
    }

    $respuesta = array("html"=>$html);
    echo json_encode($respuesta);
}

if(isset($_POST['zona'])){

    $modulo = dameModulo($_POST['zona']);

    $html = "<option style='background-color: #808080; color:white' value=''>- Seleccione un modulo -</option>";
    foreach($modulo as $indice => $registro){
        $html .= "<option value='".$registro['id']."'>".$registro['nombre']."</option>";
    }

    $respuesta = array("html"=>$html);
    echo json_encode($respuesta);
}

//if(isset($_POST['planta'])){

  //  $imagen = dameImagen($_POST['planta']);

   // $html = "<option style='background-color: #808080; color:white' value=''>- Seleccione una Planta -</option>";
   // foreach($imagen as $indice => $registro){
     //   $html .= "<option value='".$registro['id']."'><img src='imagenes/planos/".$registro['nombre'] . "' alt='Imagen'></option>";
   // }

    //$respuesta = array("html"=>$html);
   //echo json_encode($respuesta);
//}



?>