<?php
require('./components/fpdf/fpdf.php');

$nombre = $_GET['n'];
$apellido = $_GET['a'];

$dni = $_GET['dni'];
$fa = $_GET['fa'];
$fc = $_GET['fc'];
$h = $_GET['h'];
// $detalle = $_GET['d'];{
$detalle = '';


$font = 'times';
class PDF extends FPDF
{

function Header()
{
    $this->Image('./assets/images/waves.png',0,0);
    $this->Image('./assets/images/cuadrados.png',112,190,100);
    // Logo
    $this->Image('./assets/images/logo.png',165,8,33);

    // Título
    $this->SetY(20);
    $this->SetFont('Arial','B',28);
    $this->Cell(65);
    $this->Cell(70,10,'Informe de turno','B',0,'C');
    $this->Ln(15);
}
}

// Creación del objeto de la clase heredada
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage();

// esta es de la linea de separacion
$pdf->SetX(50);
$pdf->Cell(0,10,'','B',1);
$pdf->Ln(15);

// seccion de nombre y apellido
$pdf->SetX(60);
$pdf->SetFont('arial','B',18);
$pdf->Cell(40,10,utf8_decode($nombre . ' ' . $apellido),'B',1, 'C');
$pdf->Ln(5);

//seccion de dni
$pdf->SetX(50);
$pdf->SetFont($font,'B',14);
$pdf->Cell(40,10,utf8_decode('DNI del paciente: '),0,0);
$pdf->SetFont($font,'',14);
$pdf->Cell(50,10,utf8_decode($dni),0,1);
$pdf->Ln(5);

//seccion de Creación
$pdf->SetX(50);
$pdf->SetFont($font,'B',14);
$pdf->Cell(63,10,utf8_decode('Fecha de creacion de Turno: '),0,0);
$pdf->SetFont($font,'',14);
$pdf->Cell(50,10,utf8_decode($fc),0,1);
$pdf->Ln(5);

//seccion de Fecha atención
$pdf->SetX(50);
$pdf->SetFont($font,'B',14);
$pdf->Cell(57,10,utf8_decode('Fecha atención de Turno: '),0,0);
$pdf->SetFont($font,'',14);
$pdf->Cell(50,10,utf8_decode($fa),0,1);
$pdf->Ln(5);

//seccion de Horario
$pdf->SetX(50);
$pdf->SetFont($font,'B',14);
$pdf->Cell(43,10,utf8_decode('Horario del turno: '),0,0);
$pdf->SetFont($font,'',14);
$pdf->Cell(50,10,utf8_decode($h),0,1);
$pdf->Ln(5);

//seccion de detalles
$pdf->SetX(50);
$pdf->SetFont($font,'B',14);
$pdf->Cell(40,10,utf8_decode('Detalles: '),0,1);
$pdf->SetFont($font,'',14);
$pdf->SetX(60);
$pdf->Cell(50,10,utf8_decode($detalle),0,1);

$pdf->Output('','informe.pdf');
?>