
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Modificar Usuario", "<img src=''>");
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

       if ($_POST) {

           //DATOS A GUARDAR.
           $id=$_POST['id'];
           $nombre=$_POST['nombre'];
           $usuarioo=$_POST['usuario'];
           $perfil=$_POST['perfil'];
           $borrar=$_POST['borrar'];
           $ver=$_POST['ver'];
           $editar=$_POST['editar'];
           //$email=$_POST['email'];
          // $telefono=$_POST['telefono'];
          // $imagen=$_FILES['imagen']['name'];
           //$imagenAnterior=$_POST['imagenAnterior'];

           //if ($imagen =="")
             //  $imagen = $_POST['imagenAnterior'];


               $sql= "UPDATE usuarios SET
                    usuario = :usuario,
                    nombre = :nombre,
                    perfil = :perfil,
                    borrar = :borrar,
                    ver = :ver,
                    editar = :editar
                    WHERE id = :id";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':usuario', $usuarioo);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':perfil', $perfil);
               $stmt->bindParam(':borrar', $borrar);
               $stmt->bindParam(':ver', $ver);
               $stmt->bindParam(':editar', $editar);


               $stmt->execute();

               //SUBIR IMAGEN
               //echo $stmt->rowCount();
              // $origen= $_FILES['imagen']['tmp_name'];
               //$destino= "imagenes/contactos/".$imagen;

               //CONTROLAR SI FALLA
          //     if ($imagen != "" && move_uploaded_file($origen, $destino) === FALSE) {
            //       echo '<div class="alert alert-danger" role="alert">Error al subir imagen</div>';
             //  }



                   echo '<div class="alert alert-success" role="alert">Usuario Modificado</div>';
               } catch(PDOException $e) {
                   echo 'Error: ' . $e->getMessage();
               }

               } else {
                   try {
                       $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
                       $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                   if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

                       $sql= "SELECT * from usuarios WHERE id = ".$_GET['id'];


                       $stmt = $pdo->query($sql);
                       $stmt->setFetchMode(PDO::FETCH_ASSOC);

                       $row = $stmt->fetch();
                      $id=$row['id'];
                      $usuarioo=$row['usuario'];
                       $nombre=$row['nombre'];
                       $perfil=$row['perfil'];
                      $borrar=$row['borrar'];
                       $ver=$row['ver'];
                       $editar=$row['editar'];

                   } else
                       echo "Datos incorrectos";
                   } catch (PDOException $err) {
                       // Mostramos un mensaje genérico de error.
                       echo "Error: ejecutando consulta SQL.";
                   }
                }

        ?>



        <form role="form" action="modificarusuario.php" method="post" enctype="multipart/form-data">
            <div style="color: white; width: 190px;" class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" readonly
                       placeholder="Id del usuario" value="<?php echo $id; ?>">
            </div>

            <div style="color: white; width: 190px;" class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                       placeholder="Nombre del usuario" value="<?php echo $nombre; ?>">
            </div>

            <div style="color: white; width: 190px;" class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario"
                       placeholder="Usuario" value="<?php echo $usuarioo; ?>">
            </div>


            <?php

            if (isset($_SESSION['logeado'])) {
                echo  '<div class="form-group">
                <label style="color: white;" for="perfil">Perfil</label>

                <select id="perfil" name="perfil">
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario" selected="selected">Usuario</option>
                </select>
            </div>';

                echo  '<div class="form-group">
                <label style="color: white;"  for="borrar">Borrar Incidencia</label>

                <select id="borrar" name="borrar">
                    <option value="Si">Si</option>
                    <option value="No" selected="selected">No</option>
                </select>
            </div>';

                echo  '<div class="form-group">
                <label style="color: white;"  for="ver">Ver Incidencia</label>

                <select id="ver" name="ver">
                    <option value="Si" selected="selected">Si</option>
                    <option value="No">No</option>
                </select>
            </div>';
            }

            echo  '<div class="form-group">
                <label style="color: white;"  for="borrar">Editar Incidencia</label>

                <select id="editar" name="editar">
                    <option value="Si">Si</option>
                    <option value="No" selected="selected">No</option>
                </select>
            </div>';

            ?>

            <button type="submit" class="btn btn-default">GUARDAR</button>
            <a href="usuarios.php" class="btn btn-info">VOLVER</a>

        </form>





<?php pie() ?>