<?php

$id = $_POST['id'];
$nome = $_POST['nome'];
$desc = $_POST['descricao'];
$valorMensal = "'".$_POST['valorMensal']."'";
$valorAnual = "'".$_POST['valorAnual']."'";
$edital = $_POST['edital'];

//var_dump($id, $nome, $desc, $valorMensal, $valorAnual, $edital);
//var_dump(!empty($valorAnual));

if(!empty($id) && !empty($nome) && !empty($desc) && (!empty($valorAnual) || $valorAnual == "0") && (!empty($valorMensal) || $valorMensal == "0") && !empty($edital) ){

    require_once('DB.php');

    $sql = "UPDATE modalidade SET mod_nome = '".$nome."', mod_descricao = '".$desc."', mod_valMensal = ".$valorMensal.", mod_valAnual = ".$valorAnual.", mod_edital = '".$edital."' WHERE mod_id = '".$id."' ";
    
    $query = mysqli_query($connect,$sql);

    if($query){
        header('location: ../pages/consultarModalidadeEdit.php?mod_id='.$id.'&modalidade-alterada=true'); 
    }else{
        header('location: ../pages/consultarModalidadeEdit.php?mod_id='.$id.'&erro-alterar=true'); 
    }

}else{
    echo "<div class='alert alert-info' role='alert' > Preencha todos os campos </div>";
}
