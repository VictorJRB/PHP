
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera(".Modificar Incidencia", "<img src=''>");

       session_start();

       if (!isset($_SESSION['logeado'])) {
           //echo "No tienes permiso para ver la pagina</br>";
           // echo "<h2><a href='login.php'>Logeate</a></h2>";


           header("location: login.php");

           exit;
       }



       if ($_POST) {

           //DATOS A GUARDAR.
           $id=$_POST['id'];
          // $tecnico=$_POST['id_tecnico'];
           $historial=$_POST['historial'];
           $prioridad=$_POST['prioridad'];




               $sql= "UPDATE informe_incidencia SET
                    historial = :historial,
                    prioridad = :prioridad
                    WHERE id = :id";


           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':historial', $historial);
               $stmt->bindParam(':prioridad', $prioridad);

               $stmt->execute();



                   echo '<div class="alert alert-success" role="alert">Incidencia Modificada</div>';
               } catch(PDOException $e) {
                   echo 'Error: ' . $e->getMessage();
               }

               } else {
                   try {
                       $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
                       $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );


                       if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

                       $sql= "SELECT * from informe_incidencia WHERE id = ".$_GET['id'];

                       $stmt = $pdo->query($sql);
                       $stmt->setFetchMode(PDO::FETCH_ASSOC);


                       $row = $stmt->fetch();
                      $id=$row['id'];
                       $tecnico=$row['id_tecnico'];
                       $historial=$row['historial'];
                       $prioridad=$row['prioridad'];


                           for ($i=0;$i<count($prioridad);$i++)
                           {
                               echo "<br> <div style='color:white;'><b>Prioridad</b><br> " . $prioridad[$i]."</div>";
                           }

                   } else
                       echo "Datos incorrectos";
                   } catch (PDOException $err) {
                       // Mostramos un mensaje genérico de error.
                       echo "Error: ejecutando consulta SQL.";
                   }
                }

       try {
           if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

               //$sql= "SELECT * from libros WHERE id = ".$_GET['id'];
               $sql= "SELECT informe_incidencia.*, usuarios.nombre as id_tecnico, planta.nombre as id_planta, zona.nombre as id_zona, modulo.nombre as id_modulo, subincidencia.nombre as id_subincidencia, incidencia.nombre as id_incidencia
           from informe_incidencia LEFT JOIN usuarios ON informe_incidencia.id_tecnico=usuarios.id LEFT JOIN planta ON informe_incidencia.id_planta=planta.id
           LEFT JOIN zona ON informe_incidencia.id_zona=zona.id LEFT JOIN modulo ON informe_incidencia.id_modulo=modulo.id
           LEFT JOIN subincidencia ON informe_incidencia.id_subincidencia=subincidencia.id
           LEFT JOIN incidencia ON informe_incidencia.id_incidencia=incidencia.id
           HAVING id = ".$_GET['id'];

               //$sql2="SELECT * from historial_prestamo";


               $stmt = $pdo->query($sql);
               // $stmt = $pdo->query($sql2);
               $stmt->setFetchMode(PDO::FETCH_ASSOC);

               $row = $stmt->fetch();
               echo '<div style="color:white; width: 400px;">';
               echo "<td><b>Zona</b></br> ".$row['id_zona']."</td>". "</br>";
               echo "<td><b>Módulo</b></br> ".$row['id_modulo']."</td>". "</br>";
               echo '</div> <br>';

               # Para liberar los recursos utilizados en la consulta SELECT
               $stmt = null;

           } else
               echo "";

       } catch (PDOException $err) {
           // Mostramos un mensaje genérico de error.
           echo "Error: ejecutando consulta SQL.";
       }
        ?>


       <form role="form" action="modificarincidencia.php" method="post" enctype="multipart/form-data">
           <div class="form-group" style="width: 10%;">
               <label for="id" style="color: white;">ID</label>
               <input type="text" class="form-control" id="id" name="id" readonly
                      placeholder="Id de la incidencia" value="<?php echo $id; ?>">
           </div>

           <div style="float: left;" class="form-group">
               <label value="<?php echo $historial; ?>" for="historial" style="color: white;">Historial</label>
               <textarea type="text" class="form-control" id="historial" name="historial" placeholder="Historial" style="height: 240px; width: 400px; background-color: lightgrey; font-weight: bold;"><?php echo $historial; ?></textarea>
           </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <div style="float: left;" class="form-group">
               <label style="color: white;" for="prioridad">Prioridad</label>
               <select id="prioridad" name="prioridad">
                   <option value="Si">Si</option>
                   <option value="No" selected="selected">No</option>
               </select>
           </div><br><br>

           <button type="submit" class="btn btn-default">GUARDAR</button>
           <a href="incidencias-generales.php" class="btn btn-info">VOLVER</a>


       </form>



<?php pie() ?>