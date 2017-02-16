
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Planos", "<img src='http://www.museoelder.org/imagencorporativa/logoelder02.jpg'>");

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
            $planta=$_POST['nombre_planta'];
           $foto=$_FILES['imagen']['name'];

           // guardar base datos
           $sql= "INSERT INTO plano values (null, :imagen, :nombre_planta)";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':imagen', $foto);
               $stmt->bindParam(':nombre_planta', $planta);


               $stmt->execute();

               //echo $stmt->rowCount();
               $origen= $_FILES['imagen']['tmp_name'];
               $destino= "imagenes/modulo/".$foto;

               //CONTROLAR SI FALLA
               if ($foto != "" && move_uploaded_file($origen, $destino) === FALSE) {
                   echo '<div class="alert alert-danger" role="alert">Error al subir imagen</div>';
               }



               echo '<div class="alert alert-success" role="alert">Registro Insertado</div>';
           } catch(PDOException $e) {
               echo 'Error: ' . $e->getMessage();
           }

           }
        ?>



        <form role="form" action="subirplano.php" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="nombre_planta">Planta</label>
                <input style="width: 200px;" type="text" class="form-control" id="nombre_planta" name="nombre_planta" placeholder="Planta">
            </div>

            <div class="form-group">
                <label for="imagen">Plano</label>
                <input type="file" id="imagen" name="imagen">
            </div>



            <button type="submit" class="btn btn-default">GUARDAR</button>
            <a href="planos.php" class="btn btn-info">VOLVER</a>
        </form>



<?php pie() ?>