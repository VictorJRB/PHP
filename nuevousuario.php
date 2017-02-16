
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Nuevo Usuario", "<img src=''>");

       session_start();

       if (!isset($_SESSION['logeado'])) {

       }

       if ($_SESSION['perfil'] != "Administrador") {
           echo "<h1 class='container text-center'>NO TIENES PERMISO PARA VER LA PÁGINA</h1>";
           exit;
       }

       if ($_POST) {

           //DATOS A GUARDAR.

           $nombre=$_POST['nombre'];
           $usuario=$_POST['usuario'];
           $clave=md5($_POST['clave']);
          // $email=$_POST['email'];
           $perfil=$_POST['perfil'];
           $borrar=$_POST['borrar'];
           $editar=$_POST['editar'];
           $ver=$_POST['ver'];

           // guardar base datos
           $sql= "INSERT INTO usuarios(id, usuario, clave, nombre, perfil, borrar, ver, editar) values (null, :usuario, :clave, :nombre, :perfil, :borrar, :ver, :editar)";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $user, $pass);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':usuario', $usuario);
               $stmt->bindParam(':clave', $clave);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':perfil', $perfil);
               $stmt->bindParam(':borrar', $borrar);
               $stmt->bindParam(':ver', $ver);
               $stmt->bindParam(':editar', $editar);

               $stmt->execute();

               echo '<div class="alert alert-success" role="alert">Registro Confirmado</div>';
           } catch(PDOException $e) {
               echo 'Error: ' . $e->getMessage();
           }

           }

        ?>



        <form role="form" action="nuevousuario.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
            </div>

            <div class="form-group">
                <label for="usuario">Nombre de Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de Usuario" required>
            </div>
            <div>
                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave" required>
            </div><br><br>

            <?php

            if (isset($_SESSION['logeado'])) {
           echo  '<div class="form-group">
                <label for="perfil">Perfil</label>

                <select id="perfil" name="perfil">
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario" selected="selected">Usuario</option>
                </select>
            </div>';

                echo  '<div class="form-group">
                <label for="borrar">Borrar Incidencia</label>

                <select id="borrar" name="borrar">
                    <option value="Si">Si</option>
                    <option value="No" selected="selected">No</option>
                </select>
            </div>';

                echo  '<div class="form-group">
                <label for="ver">Ver Incidencia</label>

                <select id="ver" name="ver">
                    <option value="Si">Si</option>
                    <option value="No" selected="selected">No</option>
                </select>
            </div>';
            }

            echo  '<div class="form-group">
                <label for="borrar">Editar Incidencia</label>

                <select id="editar" name="editar">
                    <option value="Si">Si</option>
                    <option value="No" selected="selected">No</option>
                </select>
            </div>';

?>

<div class="container">
            <button type="submit" class="btn btn-info">CONFIRMAR REGISTRO</button>
    <a href="usuarios.php" class="btn btn-info">VOLVER</a>

</div>


        </form>



<?php pie() ?>