<?php
require('plugins/fpdf/fpdf.php');
require('classes/diag.php');

$pdf = new PDF_Diag();
$pdf->AddPage();

$data[0] = array(470, 490, 90);
$data[1] = array(450, 530, 110);
$data[2] = array(420, 580, 100);

// Column chart
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(210, 5, 'Gráfico', 0, 1, 'C');
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
$pdf->ColumnChart(110, 100, $data, null, array(255,175,100));
//$pdf->SetXY($valX, $valY);

$pdf->Output();
?>