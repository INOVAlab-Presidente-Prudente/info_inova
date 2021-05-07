<?php

$nome = $_POST['nome'];
$desc = $_POST['descricao'];
$valorMensal = $_POST['valorMensal'];
$valorAnual = $_POST['valorAnual'];
$edital = $_POST['edital'];

if(!empty($nome) && !empty($desc) && (!empty($valorAnual) || $valorAnual == "0") && (!empty($valorMensal) || $valorMensal == "0") && !empty($edital) ){
    require_once('DB.php');
    $sql = "INSERT INTO modalidade (mod_nome, mod_descricao,mod_valMensal, mod_valAnual, mod_edital) VALUES ('".$nome."', '".$desc."', ".$valorMensal.", ".$valorAnual.", '".$edital."')";
    $query = mysqli_query($connect,$sql);
    if($query)
        echo "<div class='alert alert-success' role='alert' >Modalidade cadastrada </div>"; 
    else
        echo "<div class='alert alert-info' role='alert' >Nao foi possivel cadastrar modalidade </div>";
    
} else
    echo "<div class='alert alert-warning' role='alert'> Preencha todos os campos </div>";

    