<?php
function conectaBaseDatos(){
    try{
        $servidor = "localhost";
        $bbdd = "incidencias";
        $puerto = "3306";
        $usuario = "root";
        $clave= "";

        $conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$bbdd",
            $usuario,
            $clave,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conexion;
    }
    catch (PDOException $e){
        die ("No se puede conectar a la base de datos". $e->getMessage());
    }
}


function dameIncidencia(){
    $resultado = false;
    $consulta = "SELECT * FROM incidencia";

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }

    return $resultado;
}


function dameSub($incidencia = ""){
    $resultado = false;
    $consulta = "SELECT * FROM subincidencia";

    if($incidencia != ""){
        $consulta .= " WHERE id_incidencia = :incidencia";
    }

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bindParam('incidencia',$incidencia);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }

    return $resultado;
}

?>