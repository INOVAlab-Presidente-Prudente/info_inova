<?php
    require("DB.php");
    // Tempo medio e quantidade de checkin
    $sql = "SELECT r.cont, sec_to_time(r.res/r.cont) AS tempo_total FROM (
            SELECT COUNT(che_id) AS cont, SUM(TIME_TO_SEC(TIMEDIFF(che_horario_saida, che_horario_entrada))) AS res
            FROM check_in 
            WHERE che_horario_entrada >= '".$_GET['dtInicio']." 00:00:00' AND che_horario_saida <= '".$_GET['dtFim']." 23:59:59') r;";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    $tmpMedio = explode(".",$row['tempo_total'])[0];
    $qtdeCheckin = $row['cont'];

    // Nome de usuario e area de atuacao
    $sql = "SELECT DISTINCT u.usu_id, u.usu_nome, u.usu_area_atuacao FROM usuario u, check_in c 
            WHERE c.usu_id = u.usu_id AND c.che_horario_entrada >= '".$_GET['dtInicio']." 00:00:00' 
            AND c.che_horario_saida <= '".$_GET['dtFim']." 23:59:59' ORDER BY usu_area_atuacao";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    $tabela = [];
    while($row != null){
        $sql2 = "SELECT COUNT(c.che_id) AS qtde, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(c.che_horario_saida, c.che_horario_entrada)))) AS tempo 
                    FROM check_in c WHERE c.usu_id = ".$row['usu_id']." AND c.che_horario_entrada >= '".$_GET['dtInicio']." 00:00:00' 
                    AND c.che_horario_saida <= '".$_GET['dtFim']." 23:59:59'";
        $query2 = mysqli_query($connect, $sql2);
        $row2 = mysqli_fetch_assoc($query2);

        $sql3 = "SELECT COUNT(oc_id) AS qtdeOcorrencia
                    FROM ocorrencia WHERE usu_id = ".$row['usu_id']." AND oc_data >= '".$_GET['dtInicio']." 00:00:00' 
                    AND oc_data <= '".$_GET['dtFim']." 23:59:59'";
        $query3 = mysqli_query($connect, $sql3);
        $row3 = mysqli_fetch_assoc($query3);
        $tabela[] = [
            htmlspecialchars($row['usu_nome']),
            htmlspecialchars($row2['tempo']),
            htmlspecialchars($row2['qtde']),
            htmlspecialchars($row3['qtdeOcorrencia']),
            htmlspecialchars($row['usu_area_atuacao'])
        ];
        
        $row = mysqli_fetch_assoc($query);
    }

    require("plugins/fpdf/fpdf.php");
    // require('classes/CellPDF.php');
    class PDF extends FPDF
    {
        
        function Header()
        {
            global $tmpMedio, $qtdeCheckin;
            // Logo
            $this->Image('../images/logo_relatorio.png',5,6,200);
            // $this->Image('../images/prudente.jpeg',175,2,25);
            // Arial bold 15
            $this->SetFont('Arial','B',15);
            // Title
            $this->Cell(0,65,'Relatório de Utilização do Coworking',0,1,'C');

            $this->SetFont('Arial','',12);
            $this->Cell(0,-40,'Tempo médio entre todos usuários: '.$tmpMedio.' hrs.',0,1,'L');
            $this->Cell(0,60,'Quantidade de check-in: '.$qtdeCheckin.'',0,0,'L');
            // Line break
            $this->Ln(40);
        }
        // Simple table
        function BasicTable($header, $data)
        {
            $cellWidth = 38;
            $cellHeight = 6;
            // Header
            $this->SetFillColor(189, 189, 189);
            $this->SetFont("Arial", "B");
            $this->Cell(60, $cellHeight, $header[0],1, 0, 0, true);
            $this->Cell(30, $cellHeight, $header[1],1, 0, 0, true);
            $this->Cell(30, $cellHeight, $header[2],1, 0, 0, true);
            $this->Cell(30, $cellHeight, $header[3],1, 0, 0, true);
            $this->Cell($cellWidth, $cellHeight,$header[4],1, 0, 0, true);
            $this->Ln();
            // Data
            $this->SetFont("Arial", "");
            foreach($data as $row)
            {
                $i = 1;
                $nome = $row[0];
                if (strlen($nome) > 50) {
                    $nome = substr($nome,0, 30) . "\r\n" . substr($nome, (strlen($nome) - 30) * -1);
                    // var_dump($nome);
                    // die();
                    $i = 2;
                }
                //Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
                $this->Cell(60, $cellHeight*$i, $nome ,1);
                $this->Cell(30, $cellHeight*$i, $row[1],1, 0, 'C');
                $this->Cell(30, $cellHeight*$i, $row[2],1, 0, 'C');
                $this->Cell(30, $cellHeight*$i, $row[3],1, 0, 'C');
                $this->Cell($cellWidth, $cellHeight*$i, $row[4],1);
                
                $this->Ln();
            }
        }
    }

    $pdf = new PDF();
    // Column headings
    $header = array('Usuário', 'Qtde Horas', 'Qtde Check-in', 'Qtde Ocorrencias', 'Area atuacao');
    $pdf->SetFont('Arial','',10);
    $pdf->AddPage();
    $pdf->BasicTable($header,$tabela);
    $pdf->Output('I', 'Relatorio_Coworking.pdf');