
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Nueva Zona", "<img src=''>");

       session_start();

       if (!isset($_SESSION['logeado'])) {
           //echo "No tienes permiso para ver la pagina</br>";
           // echo "<h2><a href='login.php'>Logeate</a></h2>";


           header("location: login.php");

           exit;
       }

       if ($_SESSION['perfil'] != "Administrador" ) {
           echo "<h1 class='container text-center'>NO TIENES PERMISO PARA VER LA PÁGINA</h1>";
           exit;
       }

       if ($_POST) {

           //DATOS A GUARDAR.

           $nombre=$_POST['nombre'];
           $planta=$_POST['id_planta'];

           // guardar base datos
           $sql= "INSERT INTO zona values (null, :nombre, :id_planta)";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':id_planta', $planta);




               $stmt->execute();

               //echo $stmt->rowCount();
               //$origen= $_FILES['imagen']['tmp_name'];
               //$destino= "imagenes/libros/".$foto;

               //CONTROLAR SI FALLA
             //  if ($foto != "" && move_uploaded_file($origen, $destino) === FALSE) {
              //     echo '<div class="alert alert-danger" role="alert">Error al subir imagen</div>';
               //}



               echo '<div class="alert alert-success" role="alert">Registro Insertado</div>';
           } catch(PDOException $e) {
               echo 'Error: ' . $e->getMessage();
           }

           }
       try {
           // COGER LAS PLANTAS PARA MOSTRARLO EN EL SELECT.
           $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "SELECT * FROM planta";
           $stmt = $pdo->query($sql);

           $idplanta = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
       }


        ?>



        <form role="form" action="nuevazona.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre de la zona</label>
                <input style="width: 20%" type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la zona">
            </div>

            <div class="form-group">
                <label for="id_planta">Planta</label><br>

                <select name="id_planta">
                    <?php
                    foreach ($idplanta as $planta)
                        echo "<option value=".$planta['id'].">".$planta['nombre']."</option>";
                    ?>
                </select>
            </div>



            <button type="submit" class="btn btn-default">GUARDAR</button>
            <a href="zona.php" class="btn btn-info">VOLVER</a>
        </form>



<?php pie() ?>