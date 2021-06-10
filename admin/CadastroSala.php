<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$nome = $_POST['nome'];
$localizacao = $_POST['localizacao'];
$capacidade = $_POST['capacidade'];
$valPeriodo = $_POST['valPeriodo'];
$valHora = $_POST['valHora'];
$disponivel = $_POST['disponivel'];
$caixaSom = $_POST['caixaSom'];
$computadores = $_POST['computadores'];
$iluminacao = $_POST['iluminacao'];
$mesas = $_POST['mesas'];
$cadeiras = $_POST['cadeiras'];
$climatizado = $_POST['climatizado'];
$frigobar = $_POST['frigobar'];
$projetor = $_POST['projetor'];
$cadeiraApoio = $_POST['cadeiraApoio'];
$observacoes = $_POST['observacoes'];
var_dump($climatizado);

if (!empty($nome) && !empty($localizacao) && !empty($valPeriodo) && !empty($valHora)) {
    require_once("DB.php");
    $sql = "INSERT INTO sala (sa_nome_espaco, sa_capacidade, sa_valor_periodo, sa_valor_hora, sa_localizacao, sa_ambiente_climatizado, sa_projetor, sa_caixa_som, sa_cadeiras_apoio, sa_iluminacao, sa_disponibilidade, sa_frigobar, sa_observacoes, sa_computadores, sa_mesas, sa_cadeiras) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $prepare = mysqli_prepare($connect, $sql);
    if($prepare != null)
        $bindParam = mysqli_stmt_bind_param($prepare, "siddsiiiisiisiii",
            $nome,
            $capacidade,
            $valPeriodo,
            $valHora,
            $localizacao,
            isset($_POST['climatizado']),
            isset($_POST['projetor']),
            $caixaSom,
            isset($_POST['cadeiraApoio']),
            $iluminacao,
            $disponivel,
            isset($_POST['frigobar']),
            $observacoes,
            $computadores,
            $mesas,
            $cadeiras);

    if (mysqli_stmt_execute($prepare)) {
        header("location: ../pages/consultarSala.php?sala_cadastrada=true");
    }
    else {
        var_dump(mysqli_error($connect));
    }
} else {
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspNão foi possível cadastar a sala!</h5>
            <p>Preencha todos os campos!.</p>
         </div>";
}

