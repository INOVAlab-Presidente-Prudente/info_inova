<?php

$id = $_GET['mod_id'];
$codigo = $_POST['codigo'];
$nome = $_POST['nome'];
$desc = $_POST['descricao'];
$valorMensal = $_POST['valorMensal'];
$valorAnual = $_POST['valorAnual'];
$edital = $_POST['edital'];

if(!empty($codigo) && !empty($nome) && !empty($desc) && (!empty($valorAnual) || $valorAnual == "0") && (!empty($valorMensal) || $valorMensal == "0") && !empty($edital) ){

    require_once('DB.php');

    $sql = "UPDATE modalidade SET mod_codigo = ?, mod_nome = ?, mod_descricao = ?, mod_valMensal =?, mod_valAnual = ?, mod_edital = ? WHERE mod_id = ".$id;
    $prepare = mysqli_prepare($connect, $sql);
    $bindParam = mysqli_stmt_bind_param($prepare, "sssdds", 
        $codigo,
        $nome,
        $desc,
        $valorMensal,
        $valorAnual,
        $edital);  

    if(mysqli_stmt_execute($prepare)){
        header('location: ../pages/visualizarModalidade.php?mod_id='.$id.'&modalidade-alterada=true'); 
    }else{
        header('location: ../pages/visualizarModalidade.php?mod_id='.$id.'&erro-alterar=true'); 
    }

}else{
    header('location: ../pages/visualizarModalidade.php?mod_id='.$id.'&erro-alterar=true'); 
}
