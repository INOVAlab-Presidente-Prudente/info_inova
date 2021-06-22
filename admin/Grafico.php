<?php
require('plugins/fpdf/fpdf.php');
require('classes/diag.php');

$pdf = new PDF_Diag();
$pdf->AddPage();

#$data[0] = array(470, 490, 90);
#$data[1] = array(450, 530, 110);
#$data[2] = array(420, 580, 100);
$data = [[10], [20], [30], [22], [14], [10], [20], [30], [22], [14]];

// Column chart
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(210, 5, 'Gráfico', 0, 1, 'C');
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
$pdf->ColumnChart(150, 100, $data, null) ;
//$pdf->SetXY($valX, $valY);

$pdf->Output();
?>
