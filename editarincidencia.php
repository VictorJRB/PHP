
       <?php
       require_once "funciones.php";
       require_once "config.php";
       cabecera("Editar Incidencia", "<img src=''>");
       if ($_POST) {

           //DATOS A GUARDAR.
            $id = $_POST['id'];
           $nombre=$_POST['nombre'];
           $descripcion=$_POST['descripcion'];
           $imagen=$_FILES['imagen']['name'];
          // $imagenAnterior=$_POST['imagenAnterior'];

           //if ($imagen =="")
             //  $imagen = $_POST['imagenAnterior'];


               $sql= "UPDATE informe_incidencia SET
                    nombre = :nombre,
                    imagen = :imagen,
                    descripcion = :descripcion
                    WHERE id = :id";

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':nombre', $nombre);
               $stmt->bindParam(':descripcion', $descripcion);
               $stmt->bindParam(':imagen', $imagen);


               $stmt->execute();

               //SUBIR IMAGEN
               //echo $stmt->rowCount();
               $origen= $_FILES['imagen']['tmp_name'];
               $destino= "imagenes/grupos/".$imagen;

               //CONTROLAR SI FALLA
               if ($imagen != "" && move_uploaded_file($origen, $destino) === FALSE) {
                   echo '<div class="alert alert-danger" role="alert">Error al subir imagen</div>';
               }



                   echo '<div class="alert alert-success" role="alert">Grupo Modificado</div>';
               } catch(PDOException $e) {
                   echo 'Error: ' . $e->getMessage();
               }

               } else {
                   try {
                       $pdo = new PDO("mysql:host=localhost;dbname=agenda", 'agenda', 'agenda');
                       $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                   if(isset ($_GET['id']) && is_numeric($_GET['id'])) {

                       $sql= "SELECT * from informe_incidencia WHERE id = ".$_GET['id'];


                       $stmt = $pdo->query($sql);
                       $stmt->setFetchMode(PDO::FETCH_ASSOC);

                       $row = $stmt->fetch();
                      $id=$row['id'];
                      $nombre=$row['nombre'];
                      $descripcion=$row['descripcion'];
                      $imagen=$row['imagen'];

                   } else
                       echo "Datos incorrectos";
                   } catch (PDOException $err) {
                       // Mostramos un mensaje genérico de error.
                       echo "Error: ejecutando consulta SQL.";
                   }
                }

        ?>



        <form role="form" action="modificargrupo.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" id="id" name="id" readonly
                       placeholder="Id del grupo" value="<?php echo $id; ?>">
            </div>

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre"
                       placeholder="Nombre del grupo" value="<?php echo $nombre; ?>">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion"
                       placeholder="Descripción del grupo" value="<?php echo $descripcion; ?>">
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del grupo</label>
                <input type="file" id="imagen" name="imagen" value="<?php echo $imagen; ?>">
            </div>

            <div class="form-group">
                 <img src="imagenes/grupos/<?php echo $imagen ?>" alt='Imagen del grupo' width='60'>
            </div>

            <button type="submit" class="btn btn-default">GUARDAR</button>
            <a href="usuarios.php" class="btn btn-info">VOLVER</a>


        </form>





<?php pie() ?>