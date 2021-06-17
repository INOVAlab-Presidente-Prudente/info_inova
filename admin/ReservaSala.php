<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

//reserva sala
$sa_id = $_GET['sa_id'];
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
$qtdPresentes = $_POST['qtdPresentes'];
$ministrante = $_POST['ministrante'];

//if para validar dados nulos
if( !empty($sa_id) && !empty($data) && !empty($horaInicio) && !empty($horaFim) && !empty($pagamento) && !empty($observacoes) && !empty($valTotal)){
    require_once("DB.php");
    $sql = "INSERT INTO reserva_sala (sa_id, res_inicio, res_fim, res_pagamento, res_observacoes, res_valor_total) VALUES( ?, ?, ?, ?, ?, ?);";
    var_dump($pagamento);
    $prepare = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($prepare, "issisd",
        $sa_id,
        $horaInicio,
        $horaFim,
        $pagamento,
        $observacoes,   
        $valTotal
    ); 

    if (mysqli_stmt_execute($prepare)){
        var_dump("Reserva efetuada");
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
            var_dump("evento inserido");
        }else{
            echo "<div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-info'></i>&nbspEvento Não Cadastrado!</h5>
                <p>Ocorreu um erro ao cadastrar Evento. Contate um administrador!</p>
            </div>";
            }

    }else{
        echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-info'></i>&nbspReserva Não Efetuada!</h5>
            <p>Ocorreu um erro ao cadastrar Reserva. Contate um administrador!</p>
        </div>";
    }
}else{
    echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-info'></i>&nbspReserva Não Efetuada!</h5>
            <p>Preencha todos os campos!</p>
        </div>";
}
//else 