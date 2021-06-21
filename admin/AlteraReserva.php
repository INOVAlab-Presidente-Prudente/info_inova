<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

//ids
$idEmpresa = $_POST['idEmpresa'] == "" ? null : $_POST['idEmpresa'];
$idUsuario = $_POST['idUsuario'] == "" ? null : $_POST['idUsuario'];

$evento = isset($_POST['evento']);

//reserva sala
$sa_id = $_GET['sala_id'];
$res_id = $_GET['res_id'];
$data = $_POST['data'];
$horaInicio = $data." ".$_POST['horaInicio'];
$horaFim = $data." ".$_POST['horaFim'];
$pagamento = $_POST['pagamento'];
$observacoes = $_POST['observacoes'];
$valTotal = $_POST['valTotal'];

//evento
$tipoEvento = $_POST['tipoEvento'];
$nomeEvento = $_POST['nomeEvento'];
$valEntrada = $_POST['valEntrada'];
$qtdInscritos = $_POST['qtdInscritos'];
// $qtdPresentes = $_POST['qtdPresentes'];
$ministrante = $_POST['ministrante'];

//if para validar dados nulos
if( !empty($sa_id) && !empty($data) && !empty($horaInicio) && !empty($horaFim) && !empty($observacoes) && (!empty($valTotal) || $valTotal == "0")){
    require_once("DB.php");
    $sql = "UPDATE reserva_sala SET 
            sa_id = ?, 
            usu_id = ?, 
            emp_id = ?, 
            res_inicio = ?, 
            res_fim = ?, 
            res_pagamento = ?, 
            res_observacoes = ?, 
            res_valor_total = ? WHERE res_id = ".$res_id."";
    $prepare = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($prepare, "iiissisd",
        $sa_id,
        $idUsuario,
        $idEmpresa,
        $horaInicio,
        $horaFim,
        $pagamento,
        $observacoes,   
        $valTotal
    ); 

    if (mysqli_stmt_execute($prepare)){
        echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check-square'></i>&nbsp;Reserva alterada com Sucesso!</h5>
                </div>";

        // verifica e insere evento caso nao exista na reserva
        $sql = "SELECT * FROM evento WHERE res_id = ".$res_id."";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_num_rows($query);
        if (!$row){
            $sql = "INSERT INTO evento (res_id, tip_id, eve_nome, eve_valor_entrada, eve_qtd_inscritos, eve_qtd_presentes, eve_ministrante) VALUES (".$res_id.", ".$tipoEvento.", '".$nomeEvento."', ".$valEntrada.", ".$qtdInscritos.", 0, '".$ministrante."')";
            $query = mysqli_query($connect, $sql);
        }

        // remove evento caso usuario desmarque a checkbox
        if (!$evento){
            $sql = "DELETE FROM evento WHERE res_id = ".$res_id."";
            $query = mysqli_query($connect, $sql);
        }

        // altera os dados atuais do evento
        if ($evento) {
            $qtdPresentes = 0;
            $sql = "UPDATE evento SET
                res_id = ?, 
                tip_id = ?, 
                eve_nome = ?, 
                eve_valor_entrada = ?, 
                eve_qtd_inscritos = ?, 
                eve_qtd_presentes = ?, 
                eve_ministrante = ? WHERE res_id = ".$res_id."";
            $prepare = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($prepare, "iisdiis",
                $res_id,
                $tipoEvento,
                $nomeEvento,
                $valEntrada,
                $qtdInscritos,
                $qtdPresentes,
                $ministrante
            ); 
            if (!mysqli_stmt_execute($prepare)){
                echo "<div class='alert alert-info alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-info'></i>&nbspEvento Não Alterado!</h5>
                    <p>Ocorreu um erro ao alterar Evento. Contate um administrador!</p>
                </div>";
            }
        }

    }else{
        echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-info'></i>&nbspReserva Não Alterada!</h5>
            <p>Ocorreu um erro ao alterar Reserva. Contate um administrador!</p>
        </div>".mysqli_error($connect);
        
    }
}else{
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspReserva Não Alterada!</h5>
            <p>Preencha todos os campos!</p>
        </div>";
}