<?php
session_start();

//if (isset ($_SESSION['visitas']))
  //  $_SESSION['visitas']++;
//else
//    $_SESSION['visitas'] = 1;

//echo "visitas: ".$_SESSION['visitas'];
//exit;


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
</head>
    <?php
    require_once "funciones-fondo.php";
    require_once "config.php";
    cabecera("Login", "<img src=''>");

    //var_dump($_POST);
if ($_POST) {

           try {
               $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
               $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               $sql=('SELECT * FROM usuarios WHERE usuario = ? AND clave = md5(?)');
               $stmt = $pdo->prepare($sql);
               $stmt->bindParam(1, $_POST['usuario']);
               $stmt->bindParam(2, $_POST['clave']);
              // $stmt->bindParam(3, $_POST['perfil']);

               $stmt->execute();

               if ($stmt->rowCount() == 1 ) {
                   //COGER DATOS DEL USUARIO LOGEADO
                   $usuario = $stmt->fetch();


                    $_SESSION['usuario']=$usuario['usuario'];
                   $_SESSION['id'] = $usuario['id'];
                   $_SESSION['nombre']=$usuario['nombre'];
                   $_SESSION['perfil']=$usuario['perfil'];
                   $_SESSION['borrar']=$usuario['borrar'];
                   $_SESSION['ver']=$usuario['ver'];
                   $_SESSION['editar']=$usuario['editar'];
                   if ($_SESSION['perfil'] == "Usuario") {
                      $_SESSION['logeado'] = true;
                       header("location: index.php");
                       exit;
                   }
                   else {
                       $_SESSION['logeado'] = true;
                       header("location: index.php");
                       exit;

                   }

                   //$_SESSION['foto'];
                   $_SESSION['logeado'] = true;

                   header("location: usuarios.php");
                   exit;
               }else
                   echo '<div class="alert alert-danger" role="alert">Usuario no válido</div>';

               $stmt=null;

           }
           catch(PDOException $e) {
               echo 'Error: ' . $e->getMessage();
           }


    }

    ?>



    <title>Signin Template for Bootstrap</title>
    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div style=" height: 270px; width: 20%; margin-top: 15%; margin-left: 38%; color:white;">

    <form class="form-signin" action="login.php" method="post">
        <h2 class="form-signin-heading">Login</h2>
        <label type="text" for="usuario" class="sr-only">Usuario</label>
        <input id="usuario" name="usuario" class="form-control" placeholder="Usuario" required autofocus>



        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Recordar
            </label>
        </div>
        <button class="btn btn-lg btn-block" type="submit" name="enviar">Entrar</button>
    </form>

 <!-- /container -->

<?php
pie()
//<label type="text" for="perfil" class="sr-only">Perfil</label>
  //      <input id="perfil" name="perfil" class="form-control" placeholder="Perfil" required autofocus>
?>
</body>
</html>
