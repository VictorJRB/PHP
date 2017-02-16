
<?php
require "fpdf.php";
require_once "config.php";

session_start();

if (!isset($_SESSION['logeado'])) {
    //echo "No tienes permiso para ver la pagina</br>";
    // echo "<h2><a href='login.php'>Logeate</a></h2>";

    header("location: login.php");

    exit;
}

class PDF extends FPDF
{
}

$pdf=new PDF('L', 'mm', 'Letter');
$pdf->SetMargins(12, 8);
$pdf->AliasNbPages();
$pdf->AddPage();
$fecha=date("d/m/Y");

$pdf->setTextColor(0x00, 0x00, 0x00 );
$pdf->setFont("Arial", "I", 13);
$pdf->Cell(0, 5, 'Informe de Incidencias '.$fecha.'', 0, 1, 'R');
$pdf->SetMargins(2, 5);


try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$bbdd", $usuario, $clave);
    $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

}
catch(PDOException $e) {
    echo "Se ha producido un error al intentar conectar al servidor MySQL: ".$e->getMessage();
}



try {
    $pdf->SetMargins(12, 8);

    //$sql= "SELECT historial_prestamo.*, usuarios.nombre as usuario,
         //  from historial_prestamo LEFT JOIN usuarios ON historial_prestamo.id_usuario=usuarios.id";
    $pdf->setFont("Arial", "BI", 11);
    $pdf->Ln();
    $pdf->Cell(20, 5, "Tecnico",0,0, 'C');
    $pdf->Cell(10, 5, "Id",0,0, 'C');
    $pdf->Cell(18, 5, "Planta",0,0, 'C');
    $pdf->Cell(61, 5, "Zona",0,0, 'C');
    $pdf->Cell(60, 5, "Modulo/Pieza",0,0, 'C');
  //  $pdf->Cell(20, 5, "Fecha",0,0, 'C');
    $pdf->Cell(35, 5, "Incidencia",0,0, 'C');
    $pdf->Cell(52, 5, "Subincidencia",0,1, 'C');

    $pdf->setFont("Arial", "b", 9);


if ($_SESSION['perfil'] != "Administrador" || $_SESSION['perfil'] != "Usuario") {

if(isset ($_SESSION['id']) && is_numeric($_SESSION['id'])) {

   // $sql= "SELECT * from informe_incidencia";

    $sql= "SELECT informe_incidencia.*, planta.nombre as id_planta, usuarios.usuario as id_tecnico, zona.nombre as id_zona, modulo.nombre as id_modulo, subincidencia.nombre as id_subincidencia, incidencia.nombre as id_incidencia
           from informe_incidencia LEFT JOIN usuarios ON informe_incidencia.id_tecnico=usuarios.id LEFT JOIN planta ON informe_incidencia.id_planta=planta.id
           LEFT JOIN zona ON informe_incidencia.id_zona=zona.id LEFT JOIN modulo ON informe_incidencia.id_modulo=modulo.id
           LEFT JOIN subincidencia ON informe_incidencia.id_subincidencia=subincidencia.id
           LEFT JOIN incidencia ON informe_incidencia.id_incidencia=incidencia.id order by informe_incidencia.id_planta";
}}


    $stmt = $pdo->query($sql);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    while ($row = $stmt->fetch()) {
        $pdf->SetMargins(12, 8);


        $pdf->Cell(20, 5, $row['id_tecnico'],0,0, '');
        $pdf->setFont("Arial", "I", 9);
        $pdf->Cell(10, 5, $row['id'],0,0, '');
        $pdf->setFont("Arial", "b", 9);
        $pdf->Cell(18, 5, $row['id_planta'],0,0, '');
        $pdf->Cell(61, 5, $row['id_zona'],0,0, '');
        $pdf->Cell(60, 5, $row['id_modulo'],0,0, '');
       // $pdf->Cell(20, 5, $row['fecha'],0,0, '');
        $pdf->Cell(35, 5, $row['id_incidencia'],0,0, '');
        $pdf->Cell(52, 5, $row['id_subincidencia'],0,1, '');


    }
    $pdf->Output('incidencias.pdf','D');
    ?>


    <?php




    # Para liberar los recursos utilizados en la consulta SELECT
    $stmt = null;
} catch (PDOException $err) {
    // Mostramos un mensaje genérico de error.
    echo "Error: ejecutando consulta SQL.";

}
?>





