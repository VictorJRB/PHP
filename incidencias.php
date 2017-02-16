<head>

</head>
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
           $incidencia=$_POST['id_incidencia'];
           $zona=$_POST['id_zona'];
           $modulo=$_POST['id_modulo'];
           $subincidencia=$_POST['id_subincidencia'];
           $observacion=$_POST['observacion'];
           $fecha=$_POST['fecha'];
           $hora=$_POST['hora'];
           $fecha_fin = date('Y-m-d');
           $nuevafecha = strtotime ( '+7 day' , strtotime ( $fecha_fin ) ) ;
           $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
           $fecha_fin_mes= $nuevafecha;
           $nuevafecha2 = strtotime ( '+22 day' , strtotime ( $fecha_fin_mes ) ) ;
           $nuevafecha2 = date ( 'Y-m-d' , $nuevafecha2 );



               //echo $stmt->rowCount();
               //$origen= $_FILES['foto']['tmp_name'];
              // $destino= "imagenes/grupos/".$foto;

               //CONTROLAR SI FALLA
             //  if ($foto != "" && move_uploaded_file($origen, $destino) === FALSE) {
             //      echo '<div class="alert alert-danger" role="alert">Error al subir imagen</div>';
            //   }
           // guardar base datos
           $sql= "INSERT INTO informe_incidencia values (:id, :id_tecnico, :id_planta, :id_incidencia, :id_zona, :id_modulo, :id_subincidencia, :fecha, :hora, :observacion, :historial, :fecha_fin, :fecha_fin_mes, null)";
           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(':id', $id);
               $stmt->bindParam(':id_tecnico', $_SESSION['id']);
               $stmt->bindParam(':id_planta', $planta);
               $stmt->bindParam(':id_incidencia', $incidencia);
               $stmt->bindParam(':id_zona', $zona);
               $stmt->bindParam(':id_modulo', $modulo);
               $stmt->bindParam(':id_subincidencia', $subincidencia);
               $stmt->bindParam(':fecha', $fecha);
               $stmt->bindParam(':hora', $hora);
               $stmt->bindParam(':observacion', $observacion);
               $stmt->bindParam(':historial', $historial);
               $stmt->bindParam(':fecha_fin', $nuevafecha);
               $stmt->bindParam(':fecha_fin_mes', $nuevafecha2);

               $_SESSION['planta'] = $_POST['id_planta'];
               $_SESSION['zona'] = $_POST['id_zona'];


               $stmt->execute();



               echo '<div class="alert alert-success" role="alert">Incidencia Creada</div>';
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

       try {
           // COGER LAS INCIDENCIAS PARA MOSTRARLO EN EL SELECT.
           $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "SELECT * FROM incidencia";
           $stmt = $pdo->query($sql);

           $idincidencia = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
       }

       try {
           // COGER LAS INCIDENCIAS PARA MOSTRARLO EN EL SELECT.
           $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "SELECT * FROM zona";

           $stmt = $pdo->query($sql);

           $idzona = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
       }

       try {
           // COGER LAS INCIDENCIAS PARA MOSTRARLO EN EL SELECT.
           $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "SELECT * FROM modulo";
           $stmt = $pdo->query($sql);

           $idmodulo = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
       }

       try {
           // COGER LAS INCIDENCIAS PARA MOSTRARLO EN EL SELECT.
           $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           $sql = "SELECT * FROM subincidencia";
           $stmt = $pdo->query($sql);

           $idsubincidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch(PDOException $e) {
           echo '<div class="alert alert-danger" role="alert">Error:'.$e->getMessage().'</div>';
       }

    //   <?php echo '<div style="margin-top: -80px;;"><img style="width: 50%;  float: right;" id="imgt" src=""></div>';
       ?>



        <form style="margin-left: 5%;" role="form" action="incidencias.php" method="post" enctype="multipart/form-data">


            <div class="form-group">
                <label class="" for="id_tecnico"></label><br>

                <div  style="font-style: italic; height: 58px; width: 1168px; margin-top: -50px; "><h3 style="float: right; color:white; font-size: 38px; margin-right:350px "> <?php echo $_SESSION['nombre']?></h3></div>

            </div>
            <hr>

            <div style="float: left; margin-right: 180px; position: absolute" class="form-group">
                <label for="fecha" style="color: white">Fecha</label>
                <input readonly type="text" value="<?php echo date("Y-m-d"); ?>" class="form-control" id="fecha" name="fecha" placeholder="Fecha">
            </div><br><br><br>



            <div style="float: left; margin-right: 180px; position: absolute" class="form-group">
                <label for="hora" style="color: white">Hora</label>
                <input readonly type="text" value="<?php echo date("H")-1 .date(":i"); ?>" class="form-control" id="hora" name="hora" placeholder="Hora">

            </div><br><br><br><br><br>



        <div class="form-group ">

            <label class="btn btn-info" style="color:white; margin-left: 40px; margin-bottom: 1%; font-size: 20px;">&nbsp; Planta &nbsp;</label>
            <label class="btn btn-info" for="id_zona" style="color: white; margin-left: 140px; margin-bottom: 1%; font-size: 20px;">&nbsp; Zona &nbsp;</label>
            <label class="btn btn-info" for="id_modulo" style="color: white; margin-left: 100px; margin-bottom: 1%; font-size: 20px;">&nbsp; Módulo &nbsp;</label>


            <div class="form-group ">



                <select style="float: left;" name="id_planta" id="id_planta">
                    <option value="">- Seleccione una Planta -</option>
                    <?php
                    $planta = damePlanta();

                    foreach($planta as $indice => $registro){
                        echo "<option value=".$registro['id'].">".$registro['nombre']."</option>";
                    }
                    ?>
                </select>&nbsp &nbsp



                <select name="id_zona" id="id_zona">
                    <option value="">- Seleccione primero una Planta -</option>
                </select>&nbsp &nbsp

                <select name="id_modulo" id="id_modulo">
                    <option value="">- Seleccione primero una Zona -</option>
                </select>
            </div><br><br>


            <div class="form-group ">
                <label class="btn btn-info" style="color:white; margin-left: 40px; font-size: 20px;">&nbsp; Incidencia &nbsp;</label>
                <label class="btn btn-info" for="id_subincidencia" style="color: white; margin-left: 100px; font-size: 20px;">&nbsp; Subincidencia &nbsp;</label>
            </div>

            <div style="float: left;" class="form-group">

                <select name="id_incidencia" id="id_incidencia">
                    <option style="background-color: #808080; color:white" value="">- Seleccione una Incidencia -</option>
                    <?php
                    $incidencia = dameIncidencia();

                    foreach($incidencia as $indice => $registro){
                        echo "<option style='background-color: #808080; color:white' value=".$registro['id'].">".$registro['nombre']."</option>";
                    }
                    ?>
                </select>&nbsp &nbsp



                <select name="id_subincidencia" id="id_subincidencia">
                    <option style="background-color: #808080; color:white" value="">- Seleccione primero una Incidencia -</option>
                </select>

            </div><br>

        </div>
            <hr>

            <div style="float: left;" class="form-group">
                <label class="btn btn-info" for="observacion" style="color: white; margin-left: 40px; font-size: 20px;">&nbsp; Observación &nbsp;</label><br><br>
                <textarea type="text" class="form-control" id="observacion" name="observacion" placeholder="Observación" style="height: 100px; width: 400px; background-color: #808080; color:white;"></textarea>
            </div><br><br><br><br><br><br><br><br><br>

            <div style="float: left;" class="form-group hidden">
                <label for="historial">Historial</label>
                <textarea type="text" class="form-control" id="historial" name="historial" placeholder="Historial" style="height: 120px; width: 400px;"></textarea>

            </div>



            <button style="float: left;" type="submit" class="btn btn-success">GUARDAR</button>&nbsp; &nbsp; &nbsp;
            <a href="index.php" class="btn btn-info">VOLVER</a>
            <a style="margin-left: 6%;" href="planos.php" class="btn btn-info">IR A PLANOS</a>



        </form>

<?php pie() ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="acciones.js"></script>
<script>
    $(document).ready(function(){
        $("#id_planta").on("change", buscarZona);
        $("#id_zona").on("change", buscarModulo);
        $("#id_imagen").on("change", buscarImagen);
    });
</script>

<script src="acciones2.js"></script>
<script>
    $(document).ready(function(){
        $("#id_incidencia").on("change", buscarSub);
    });
</script>

<script  type = "text/javascript" >
    function getImage ( v )  {
        var num = v . value ;
        //alert ( num );

        if ( num == 1 )  {
            document . getElementById ( "imgt" ). setAttribute ( "src" , "imagenes/planos/Planta-Baja.jpg" );
        }

        if ( num == 2 )  {
            document . getElementById ( "imgt" ). setAttribute ( "src" , "imagenes/planos/Planta-Primera.jpg" );
        }

        if ( num == 3 )  {
            document . getElementById ( "imgt" ). setAttribute ( "src" , "imagenes/planos/Planta-Segunda.jpg" );
        }

        if ( num == 4 )  {
            document . getElementById ( "imgt" ). setAttribute ( "src" , "imagenes/planos/Planta-Tercera.jpg" );
        }
    }
</script>
</html>