<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$nome = $_POST['nome'];
$localizacao = $_POST['localizacao'];
$capacidade = $_POST['capacidade'];
$valPeriodo = $_POST['valPeriodo'];
$valHora = $_POST['valHora'];
$disponivel = isset($_POST['disponivel']);
$caixaSom = $_POST['caixaSom'];
$computadores = $_POST['computadores'];
$iluminacao = $_POST['iluminacao'];
$mesas = $_POST['mesas'];
$cadeiras = $_POST['cadeiras'];
$climatizado = isset($_POST['climatizado']);
$frigobar = isset($_POST['frigobar']);
$projetor = isset($_POST['projetor']);
$cadeiraApoio = isset($_POST['cadeiraApoio']);
$observacoes = $_POST['observacoes'];

if (!empty($nome) && !empty($localizacao) && (!empty($valPeriodo) || $valPeriodo == "0" ) && (!empty($valHora) || $valHora == "0") ) {
    $sql = "UPDATE sala SET 
    sa_nome_espaco = ?,
    sa_capacidade = ?,  
    sa_valor_periodo = ?, 
    sa_valor_hora = ?, 
    sa_localizacao = ?, 
    sa_ambiente_climatizado = ?, 
    sa_projetor = ?, 
    sa_caixa_som = ?, 
    sa_cadeiras_apoio = ?, 
    sa_iluminacao = ?, 
    sa_disponibilidade = ?, 
    sa_frigobar = ?, 
    sa_observacoes = ?, 
    sa_computadores = ?,
    sa_mesas = ?,
    sa_cadeiras = ?
    WHERE sa_id = '".$_GET['sala_id']."'"; 
    
    $prepare = mysqli_prepare($connect, $sql);
    $bindParam = mysqli_stmt_bind_param($prepare, "siddsiiiisiisiii",
        $nome,
        $capacidade,
        $valPeriodo,
        $valHora,
        $localizacao,
        $climatizado,
        $projetor,
        $caixaSom,
        $cadeiraApoio,
        $iluminacao,
        $disponivel,
        $frigobar,
        $observacoes,
        $computadores,
        $mesas,
        $cadeiras);
        
    if (mysqli_stmt_execute($prepare)){
        header("location: ../pages/visualizarSala.php?sala_id=".$_GET['sala_id']."&sala_alterada=true");
    }
    else{
        header("location: ?sala_id=".$_GET['sala_id']."&sala_nao_alterada=true");
    }
} else {
    header("location: ?sala_id=".$_GET['sala_id']."&falta_dados=true");
}