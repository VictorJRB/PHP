<?php
require_once("funciones2.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo $titulo ?></title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" media="screen">

</head>
<body style="background-color: lightslategray;">

<form style="width: 480px">
    <fieldset>
        <legend>Seleccione su entidad federativa</legend>
        <label>Planta</label><br>

        <select name="planta" id="planta">
            <option value="">- Seleccione una Planta -</option>
            <?php
            $planta = damePlanta();

            foreach($planta as $indice => $registro){
                echo "<option value=".$registro['id'].">".$registro['nombre']."</option>";
            }
            ?>
        </select>
        <br><br>
        <label>Municipio:</label>
        <select name="municipio" id="municipio">
            <option value="">- primero seleccion un estado -</option>
        </select>
        <br><br>
        <label>Localidad:</label>
        <select name="localidad" id="localidad">
            <option value="">- primero seleccione un municipio -</option>
        </select>
    </fieldset>

</form>

</body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#planta").on("change", buscarMunicipios);
    });
    function buscarMunicipios(){
        alert("ya cambie");
    }
</script>
</html>