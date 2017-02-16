
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera(".Modificar Zona", "<img src=''>");

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
          // $tecnico=$_POST['id_tecnico'];
           $nombre=$_POST['nombre'];
           $planta=$_POST['id_planta'];



               $sql= "UPDATE zona SET
                    nombre = :nombre,
                    id_planta = :id_planta
                    WHERE id = :id";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':id_planta', $planta);


               $stmt->execute();



                   echo '<div class="alert alert-success" role="alert">Zona Modificada</div>';
               } catch(PDOException $e) {
                   echo 'Error: ' . $e->getMessage();
               }

               } else {
                   try {
                       $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
                       $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                   if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

                       $sql= "SELECT * from zona WHERE id = ".$_GET['id'];


                       $stmt = $pdo->query($sql);
                       $stmt->setFetchMode(PDO::FETCH_ASSOC);

                       $row = $stmt->fetch();
                      $id=$row['id'];
                       $nombre=$row['nombre'];
                       $planta=$row['id_planta'];

                   } else
                       echo "Datos incorrectos";
                   } catch (PDOException $err) {
                       // Mostramos un mensaje genérico de error.
                       echo "Error: ejecutando consulta SQL.";
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



       <form role="form" action="modificarzona.php" method="post" enctype="multipart/form-data">
           <div class="form-group">
               <label for="id">ID</label>
               <input type="text" class="form-control" id="id" name="id" readonly
                      placeholder="Id de la incidencia" value="<?php echo $id; ?>">
           </div>

           <div class="form-group">
               <label for="nombre">Zona</label>
               <input type="text" class="form-control" id="nombre" name="nombre"
                      placeholder="Zona" value="<?php echo $nombre; ?>">
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