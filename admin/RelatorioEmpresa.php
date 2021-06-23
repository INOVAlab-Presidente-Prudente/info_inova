<?php

require("DB.php");
$sql = "SELECT * FROM empresa";
$query = mysqli_query($connect, $sql);
$empresas = mysqli_fetch_assoc($query);

$tabela = [];
while($empresas!=null){
    $sql2 = "SELECT COUNT(usu_id) AS qtde FROM usuario WHERE emp_id = ".$empresas['emp_id'];
    $query2 = mysqli_query($connect, $sql2);
    $row = mysqli_fetch_assoc($query2);  

    $sql3 = "SELECT COUNT(r.teste) AS qtde FROM (SELECT DISTINCT u.usu_id as teste FROM check_in c, usuario u 
    WHERE u.emp_id = ".$empresas['emp_id']." AND c.usu_id = u.usu_id AND c.che_horario_entrada >= '".$_GET['dtInicio']." 00:00:00' AND c.che_horario_saida <= '".$_GET['dtFim']." 23:59:59' ) r;";
    $query3 = mysqli_query($connect, $sql3);
    $row3 = mysqli_fetch_assoc($query3);  
    
    $presenca = 0;
    if($row3 != null && $row3['qtde'] > 0 ){
        $date = date_create($_GET['dtInicio']);
        $dateStr = $_GET['dtInicio'];
        while($dateStr <= $_GET['dtFim']){
            $sql = "SELECT u.usu_id FROM check_in c, usuario u WHERE DATE(c.che_horario_entrada) = '".$dateStr."' AND c.usu_id = u.usu_id AND u.emp_id = ".$empresas['emp_id']." LIMIT 1";
            $query4 = mysqli_query($connect,$sql);
            if($query4){
                $row4 = mysqli_fetch_assoc($query4);
                if($row4)
                    $presenca++;
            }
                
            $date->add(new DateInterval('P1D'));
            $dateStr = date_format($date, 'Y-m-d');
        }


    }
    $tabela[] = [
        empty($empresas['emp_nome_fantasia'])? htmlspecialchars($empresas['emp_razao_social']) : htmlspecialchars($empresas['emp_nome_fantasia']),
        htmlspecialchars($presenca),
        htmlspecialchars($row3['qtde']),
        htmlspecialchars($row['qtde']),
        "?"
    ];
    $empresas = mysqli_fetch_assoc($query);
}
require("plugins/fpdf/fpdf.php");
class PDF extends FPDF
{
    function Header()
    {
        global $tmpMedio, $qtdeCheckin;
        // Logo
        $this->Image('../images/logo_relatorio.png',5,6,200);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Title
        $this->Cell(0,65,'Relatório de Utilização de Empresas',0,1,'C');

        $this->SetFont('Arial','',12);
        $this->Cell(0,-40,'Relatório de Utilização Empresa referente as datas '.date_format(date_create($_GET['dtInicio']),"d/m/Y").' a '.date_format(date_create($_GET['dtFim']),"d/m/Y").'',0,1,'L');
        // Line break
        $this->Ln(32);
    }
    // Simple table
    function BasicTable($header, $data)
    {
        $cellHeight = 6;
        // Header
        $this->SetFillColor(189, 189, 189);
        $this->SetFont('Arial', 'B', 10);
        $i = 1;
        foreach ($header as $h){
            if (strlen($h) > 19) {}
                $i = 2;
                $h = substr($h,0, 19) . "\r\n" . substr($h, (strlen($h) - 19) * -1);
            $this->Cell(38,$cellHeight*$i,$h,1, 0, 'C', true);
        }
        $this->Ln();
        // Data
        $this->SetFont('Arial', '', 10);
        foreach($data as $row)
        {
            $i = 1;
            $empresa = $row[0];
            if (strlen($empresa) > 15) {
                $empresa = ltrim(substr($empresa, 0, 15)) . "\r\n" . ltrim(substr($empresa, (strlen($empresa) - 15) * -1));
                $i = 2;
                if (strlen($empresa) > 30)
                    $empresa = ltrim(substr($empresa, 0, 15)) . "\r\n" . ltrim(substr($empresa, 15, 15)) . "\r\n" . ltrim(substr($empresa, (strlen($empresa) - 30) * -1));
            }
            $this->Cell(38, $cellHeight*$i, $empresa ,1);
            $this->Cell(38, $cellHeight*$i, $row[1],1, 0, 'C');
            $this->Cell(38, $cellHeight*$i, $row[2],1, 0, 'C');
            $this->Cell(38, $cellHeight*$i, $row[3],1, 0, 'C');
            $this->Cell(38, $cellHeight*$i, $row[4],1, 0, 'C');
            $this->Ln();

        }
    }
}

$pdf = new PDF();
// Column headings
$header = array('Empresa', 'Qtde de dias que a empresa compareceu', 'Qtde de funcionarios que compareceram', 'Qtde de funcionarios total', 'Tempo restante de contrato');
$pdf->SetFont('Arial','',8);
$pdf->AddPage();
$pdf->BasicTable($header,$tabela);
$pdf->Output('I', 'Relatorio_Empresas.pdf');