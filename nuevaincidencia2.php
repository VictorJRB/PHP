
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Nueva Incidencia", "<img src=''>");

       session_start();
       if (!isset($_SESSION['logeado'])) {
           //echo "No tienes permiso para ver la pagina</br>";
           // echo "<h2><a href='login.php'>Logeate</a></h2>";


           header("location: login.php");

           exit;
       }

       if ($_POST) {

           //DATOS A GUARDAR.

           //$foto=$_FILES['foto']['name'];

           $planta=$_POST['id_planta'];
           //$incidencia=$_POST['id_incidencia'];
           //$zona=$_POST['id_zona'];
           //$modulo=$_POST['id_modulo'];
          // $subincidencia=$_POST['id_subincidencia'];
          // $observacion=$_POST['observacion'];
           $fecha=$_POST['fecha'];
           $hora=$_POST['hora'];



               //echo $stmt->rowCount();
               //$origen= $_FILES['foto']['tmp_name'];
              // $destino= "imagenes/grupos/".$foto;

               //CONTROLAR SI FALLA
             //  if ($foto != "" && move_uploaded_file($origen, $destino) === FALSE) {
             //      echo '<div class="alert alert-danger" role="alert">Error al subir imagen</div>';
            //   }
           // guardar base datos
           $sql= "INSERT INTO informe_incidencia values (null, :id_tecnico, :id_planta, null, null, null, null, :fecha, :hora, null, null)";
           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id_tecnico', $_SESSION['id']);
               $stmt->bindParam(':id_planta', $planta);
               $stmt->bindParam(':fecha', $fecha);
               $stmt->bindParam(':hora', $hora);


               $stmt->execute();



               echo '';
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



        <form role="form" action="nuevaincidencia.php" method="post" enctype="multipart/form-data">

            <div class="form-group" style="float: left; border-right: 2px black solid; ">
                <img src='http://fotos00.laprovincia.es/2015/03/18/646x260/elder.jpg'>
            </div>

            <div style="float: right; margin-right: 300px;" class="form-group">
                <label for="id_tecnico">Usuario</label><br>

                <div style="background-color: white;"><?php echo $_SESSION['usuario']?></div>
            </div><br><br><br>

            <div style="float: right; margin-right: 180px;" class="form-group">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha">
            </div><br><br><br><br>

            <div style="float: right; margin-right: 258px;" class="form-group">
                <label for="hora">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" placeholder="Hora">
            </div><br><br><br><br><br><br>


            <div style="float: left;" class="form-group">
                <label for="id_planta">Planta</label><br>

                <select name="id_planta">
                    <?php
                    foreach ($idplanta as $planta)
                        echo "<option value=".$planta['id'].">".$planta['nombre']."</option>";
                    ?>

                </select>
            </div><br><br><br><br>


            <a href="nuevaincidencia2.php"> <button style="float: left;" type="submit" class="btn btn-default">GUARDAR</button></a>
            <a href="index.php" style="float: left;" class="btn btn-default">VOLVER</a>




        </form>



<?php pie() ?>