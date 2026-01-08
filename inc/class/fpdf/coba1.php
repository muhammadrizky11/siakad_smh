<?php
//error reporting //////////////////////////////////////////////////////////////////////////////
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL & ~E_NOTICE);
//error reporting //////////////////////////////////////////////////////////////////////////////



require('fpdf.php');


$pdf = new FPDF('P','mm','A4');


$pdf->AddPage('P');
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'coba ya!');



$pdf->AddPage('L');
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'Hello World!');


$pdf->AddPage('P');
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'ketiga...');




$pdf->Output();
?>
