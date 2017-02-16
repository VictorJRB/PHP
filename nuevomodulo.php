
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Nuevo Módulo", "<img src=''>");

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
           $zona=$_POST['id_zona'];

           // guardar base datos
           $sql= "INSERT INTO modulo values (null, :nombre, :id_zona)";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':id_zona', $zona);




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

           $sql = "SELECT * FROM zona";
           $stmt = $pdo->query($sql);

           $idzona = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
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



        <form role="form" action="nuevomodulo.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre del módulo</label>
                <input style="width: 20%" type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del módulo">
            </div><br>

            <div style="float: left;" class="form-group">
                <label>Planta</label><br>

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
                <label for="id_zona">Zona</label><br>

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