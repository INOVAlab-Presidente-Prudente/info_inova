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
        $empresas['emp_pendencia']? 'sim' : 'não',
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
        $this->Image('../images/Logo_Inova_Prudente.png',10,6,40);
        $this->Image('../images/prudente.jpeg',175,2,25);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Relatório de Utilização de Empresas',0,0,'C');

        $this->SetFont('Arial','',12);
        $this->Cell(-77,50,'Relatório de Utilização Empresa referente as datas '.date_format(date_create($_GET['dtInicio']),"d/m/Y").' a '.date_format(date_create($_GET['dtFim']),"d/m/Y").'',0,0,'C');
        // Line break
        $this->Ln(32);
    }
    // Simple table
    function BasicTable($header, $data)
    {
        // Header
        foreach($header as $col)
            $this->Cell(38,7,$col,1);
        $this->Ln();
        // Data
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(38,6,$col,1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
// Column headings
$header = array('Empresa', 'Nº de dias que a empresa compareceu', 'Nº de funcionarios que compareceram', 'Quantidade de funcionarios total', 'Aluguel Atrasado', 'Tempo restante de contrato');
$pdf->SetFont('Arial','',8);
$pdf->AddPage();
$pdf->BasicTable($header,$tabela);
$pdf->Output('I', 'Relatorio_Empresas.pdf');