
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera(".Modificar Módulo", "<img src=''>");

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
           $zona=$_POST['id_zona'];



               $sql= "UPDATE modulo SET
                    nombre = :nombre,
                    id_zona = :id_zona
                    WHERE id = :id";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':id_zona', $zona);


               $stmt->execute();



                   echo '<div class="alert alert-success" role="alert">Módulo Modificado</div>';
               } catch(PDOException $e) {
                   echo 'Error: ' . $e->getMessage();
               }

               } else {
                   try {
                       $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
                       $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                   if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

                       $sql= "SELECT * from modulo WHERE id = ".$_GET['id'];


                       $stmt = $pdo->query($sql);
                       $stmt->setFetchMode(PDO::FETCH_ASSOC);

                       $row = $stmt->fetch();
                      $id=$row['id'];
                       $nombre=$row['nombre'];
                       $zona=$row['id_zona'];

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
       try {
           // COGER LAS PLANTAS PARA MOSTRARLO EN EL SELECT.
           $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "SELECT * FROM zona";
           $stmt = $pdo->query($sql);

           $idplanta = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
       }

        ?>



       <form role="form" action="modificarmodulo.php" method="post" enctype="multipart/form-data">
           <div style="width: 150px;" class="form-group">
               <label style="color: white;" for="id">ID</label>
               <input type="text" class="form-control" id="id" name="id" readonly
                      placeholder="Id de la incidencia" value="<?php echo $id; ?>">
           </div><br><br>

           <div style="width: 500px;" class="form-group">
               <label for="nombre" style="color: white;">Módulo</label>
               <input type="text" class="form-control" id="nombre" name="nombre"
                      placeholder="Módulo" value="<?php echo $nombre; ?>">
           </div><br><br>

           <div style="float: left;" class="form-group">
               <label style="color: white;">Planta</label><br>

               <select name="id_planta" id="id_planta">
                   <option value="">- Seleccione una Planta -</option>
                   <?php
                   $planta = damePlanta();

                   foreach($planta as $indice => $registro){
                       echo "<option value=".$registro['id'].">".$registro['nombre']."</option>";
                   }
                   ?>
               </select>
           </div><br><br><br>


           <div style="float: left;" class="form-group">
               <label style="color: white;" for="id_zona">Zona</label><br>

               <select name="id_zona" id="id_zona">
                   <option value="">- Seleccione primero una Planta -</option>
               </select>

           </div><br><br><br>
           <button type="submit" class="btn btn-default">GUARDAR</button>
           <a href="modulo.php" class="btn btn-info">VOLVER</a>


       </form>



<?php pie() ?>

       <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
       <script src="acciones.js"></script>
       <script>
           $(document).ready(function(){
               $("#id_planta").on("change", buscarZona);
           });
       </script>