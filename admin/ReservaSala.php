<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

//ids
$idEmpresa = $_POST['idEmpresa'] == "" ? null : $_POST['idEmpresa'];
$idUsuario = $_POST['idUsuario'] == "" ? null : $_POST['idUsuario'];

//reserva sala
$sa_id = $_GET['sala_id'];
$data = $_POST['data'];
$horaInicio = $data." ".$_POST['horaInicio'];
$horaFim = $data." ".$_POST['horaFim'];
$pagamento = $_POST['pagamento'];
$observacoes = $_POST['observacoes'];
$valTotal = $_POST['valTotal'];

//evento
//var_dump($_POST['evento']);
$novoEvento = isset($_POST['evento']);
$eventoSelecionado = ($novoEvento || $_POST['eventoSelect'] == "") ? null : $_POST['eventoSelect'];
$tipoEvento = $_POST['tipoEvento'];
$nomeEvento = $_POST['nomeEvento'];
$valEntrada = $_POST['valEntrada'];
$qtdInscritos = $_POST['qtdInscritos'];
$qtdPresentes = $_POST['qtdPresentes'];
$ministrante = $_POST['ministrante'];

$periodoString = $_POST['periodoEvento']; 

$dataInicio = date_format(date_create(substr($periodoString,0,10)),"Y-m-d");
$hora1 = substr($periodoString,11,5);
$dataInicio = $dataInicio." ".$hora1.":00";

$dataFim = date_format(date_create(substr($periodoString,19,10)),"Y-m-d");
$hora2 = substr($periodoString,-5);
$dataFim = $dataFim." ".$hora2.":00";

//if para validar dados nulos
if(!empty($data) && !empty($horaInicio) && !empty($horaFim) && (!empty($valTotal) || $valTotal == "0") && !(empty($idEmpresa) && empty($idUsuario))){
    require_once("DB.php");

    if($novoEvento){
        $qtdPresentes = 0;
        $sql = "INSERT INTO evento (tip_id, eve_nome, eve_valor_entrada, eve_qtd_inscritos, eve_qtd_presentes, eve_ministrante, eve_dataInicio, eve_dataFim) VALUES(?, ?, ?, ?, ?, ?, ?, ?);";
        $prepare = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($prepare, "isdiisss",
            $tipoEvento,
            $nomeEvento,
            $valEntrada,
            $qtdInscritos,
            $qtdPresentes,
            $ministrante,
            $dataInicio,
            $dataFim
        );
        if (mysqli_stmt_execute($prepare)){
            $eventoSelecionado = mysqli_insert_id($connect);
        }
        else{
            $eventoSelecionado = null;
            echo "<div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-info'></i>&nbspEvento Não Cadastrado!</h5>
                <p>Ocorreu um erro ao cadastrar Evento. Contate um administrador<br>Erro:".mysqli_error($connect)."!</p>
            </div>";
        }
    }
    
    //var_dump($eventoSelecionado);

    $sql = "INSERT INTO reserva_sala (sa_id, usu_id, emp_id, eve_id, res_inicio, res_fim, res_pagamento, res_observacoes, res_valor_total) VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $prepare = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($prepare, "iiiissisd",
        $sa_id,
        $idUsuario,
        $idEmpresa,
        $eventoSelecionado,
        $horaInicio,
        $horaFim,
        $pagamento,
        $observacoes,   
        $valTotal
    );
    if (mysqli_stmt_execute($prepare)){
        echo "<div class='alert alert-success alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-check-square'></i>&nbspReserva realizada com Sucesso!</h5>
            </div>";
    }else{
        echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-info'></i>&nbsp;Reserva Não Efetuada!</h5>
            <p>Ocorreu um erro ao cadastrar Reserva. Contate um administrador!\nErro:".mysqli_error($connect)."</p>
        </div>";
    }
}else{
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbsp;Reserva Não Efetuada!</h5>
            <p>Preencha todos os campos!</p>
        </div>";
}
//else 