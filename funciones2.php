<?php
function cabecera ($titulo="Biblioteca", $encabezado="") {
    header('Content-Type: text/html; charset=UTF-8');}

function conectaBaseDatos(){
    header('Content-Type: text/html; charset=UTF-8');
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


function damePlanta(){
    header('Content-Type: text/html; charset=UTF-8');
    $resultado = false;
    $consulta = "SELECT * FROM planta";

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


function dameZona($planta = ""){
    header('Content-Type: text/html; charset=UTF-8');
    $resultado = false;
    $consulta = "SELECT * FROM zona";

    if($planta != ""){
        $consulta .= " WHERE id_planta = :planta";
    }

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bindParam('planta',$planta);

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

function dameModulo($zona = ""){
    header('Content-Type: text/html; charset=UTF-8');
    $resultado = false;
    $consulta = "SELECT * FROM modulo";

    if($zona != ""){
        $consulta .= " WHERE id_zona = :zona";
    }

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bindParam('zona',$zona);

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

function dameIncidencia(){
    header('Content-Type: text/html; charset=UTF-8');
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

function dameSubincidencia($incidencia = ""){
    header('Content-Type: text/html; charset=UTF-8');
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

function dameImagen($planta= ""){
    header('Content-Type: text/html; charset=UTF-8');
    $resultado = false;
    $consulta = "SELECT * FROM imagen";

    if($planta != ""){
        $consulta .= " WHERE id_planta = :planta";
    }

    $conexion = conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);
    $sentencia->bindParam('planta',$planta);

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