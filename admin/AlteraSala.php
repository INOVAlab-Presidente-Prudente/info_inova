<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$nome = $_POST['nome'];
$capacidade = $_POST['capacidade'];
$localizacao = $_POST['localizacao'];
$valPeriodo = $_POST['valPeriodo'];
$valHora = $_POST['valHora'];
$disponivel = $_POST['disponivel'];
$caixaSom = $_POST['caixaSom'];
$climatizado = $_POST['climatizado'];
$frigobar = $_POST['frigobar'];
$projetor = $_POST['projetor'];
$cadeiraApoio = $_POST['cadeiraApoio'];
$iluminacao = $_POST['iluminacao'];
$observacoes = $_POST['observacoes'];
$computadores = $_POST['computadores'];
$mesas = $_POST['mesas'];
$cadeiras = $_POST['cadeiras'];

if (!empty($nome) && !empty($localizacao) && !empty($valPeriodo) && !empty($valHora)) {
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
    WHERE sa_id = '".$_GET['sa_id']."'"; 
    
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
    //var_dump($prepare);
    //var_dump($bindParam);
    if (mysqli_stmt_execute($prepare)){
        header("location: ../pages/visualizarSala.php?sala_id=".$_GET['sala_id']."&sala_alterada=true");
    }
    else{
        header("location: ?sala_id=".$_GET['sala_id']."&sala_nao_alterada=true");
    }
} else {
    header("location: ?sala_id=".$_GET['sala_id']."&falta_dados=true");
}