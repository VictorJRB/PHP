
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Modificar Contraseña", "<img src=''>");
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
           $usuarioo=$_POST['usuario'];
           $passw=md5($_POST['clave']);
           //$email=$_POST['email'];
          // $telefono=$_POST['telefono'];
          // $imagen=$_FILES['imagen']['name'];
           //$imagenAnterior=$_POST['imagenAnterior'];

           //if ($imagen =="")
             //  $imagen = $_POST['imagenAnterior'];


               $sql= "UPDATE usuarios SET
                    usuario = :usuario,
                    clave = :clave
                    WHERE id = :id";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':usuario', $usuarioo);
               $stmt->bindParam(':clave', $passw);

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
                       $passw=$row['clave'];
                   } else
                       echo "Datos incorrectos";
                   } catch (PDOException $err) {
                       // Mostramos un mensaje genérico de error.
                       echo "Error: ejecutando consulta SQL.";
                   }
                }

        ?>



        <form role="form" action="modificarpass.php" method="post" enctype="multipart/form-data">
            <div style="color: white; width: 190px;" class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" readonly
                       placeholder="Id del usuario" value="<?php echo $id; ?>">
            </div>


            <div style="color: white; width: 190px;" class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" readonly
                       placeholder="Usuario" value="<?php echo $usuarioo; ?>">
            </div>

            <div style="color: white; width: 190px;" class="form-group">
                <label for="clave">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave"
                       placeholder="Clave del usuario" value="<?php echo $passw; ?>">
            </div>




            <button type="submit" class="btn btn-default">GUARDAR</button>
            <a href="usuarios.php" class="btn btn-info">VOLVER</a>

        </form>





<?php pie() ?>