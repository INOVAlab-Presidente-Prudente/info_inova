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
$evento = isset($_POST['evento']);
$tipoEvento = $_POST['tipoEvento'];
$nomeEvento = $_POST['nomeEvento'];
$valEntrada = $_POST['valEntrada'];
$qtdInscritos = $_POST['qtdInscritos'];
$qtdPresentes = $_POST['qtdPresentes'];
$ministrante = $_POST['ministrante'];

//if para validar dados nulos
if(!empty($data) && !empty($horaInicio) && !empty($horaFim) && (!empty($valTotal) || $valTotal == "0") && !(empty($idEmpresa) && empty($idUsuario))){
    require_once("DB.php");
    $sql = "INSERT INTO reserva_sala (sa_id, usu_id, emp_id, res_inicio, res_fim, res_pagamento, res_observacoes, res_valor_total) VALUES( ?, ?, ?, ?, ?, ?, ?, ?);";
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
        if($evento){
            $res_id = mysqli_insert_id($connect);
            $qtdPresentes = 0;
            $sql = "INSERT INTO evento (res_id, tip_id, eve_nome, eve_valor_entrada, eve_qtd_inscritos, eve_qtd_presentes, eve_ministrante) VALUES(?, ?, ?, ?, ?, ?, ?);";
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
            if (mysqli_stmt_execute($prepare)){
                // echo "<div class='alert alert-success alert-dismissible'>
                // <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                //     <h5><i class='fa-check-square'></i>&nbspEvento cadastrado com Sucesso!</h5>
                //     <p>Sala reservada e evento cadastrado com sucesso!</p>
                // </div>";
                
            }
            else{
                echo "<div class='alert alert-info alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-info'></i>&nbspEvento Não Cadastrado!</h5>
                    <p>Ocorreu um erro ao cadastrar Evento. Contate um administrador!</p>
                </div>";
            }
        }
        echo "<div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fa-check-square'></i>&nbspReserva realizada com Sucesso!</h5>
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