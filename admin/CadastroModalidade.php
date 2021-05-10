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
    if ($query) {
        echo "<div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-check'></i>&nbspModalidade Cadastrada!</h5>
            <p>A modalidade foi cadastrada com sucesso!.</p>
        </div>";
    } else {
        echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-info'></i>&nbspModalidade não Cadastrada!</h5>
            <p>Não foi possível cadastrar a modalidade, tente novamente!.</p>
        </div>";
    }
} else{
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspNão foi possível cadastar a modalidade!</h5>
            <p>Preencha todos os campos!.</p>
        </div>";
}


    
