<?php
$codigo = $_POST['codigo'];
$nome = $_POST['nome'];
$desc = $_POST['descricao'];
$valorMensal = $_POST['valorMensal'];
$valorAnual = $_POST['valorAnual'];
$edital = $_POST['edital'];

if(!empty($codigo) && !empty($nome) && !empty($desc) && (!empty($valorAnual) || $valorAnual == "0") && (!empty($valorMensal) || $valorMensal == "0") && !empty($edital) ){
    require_once('DB.php');
    $sql = "INSERT INTO modalidade (mod_codigo, mod_nome, mod_descricao,mod_valMensal, mod_valAnual, mod_edital) 
    VALUES (?, ?, ?, ?, ?, ?)";
    $prepare = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($prepare, "sssdds", $codigo, $nome, $desc, $valorMensal, $valorAnual, $edital);

    if (mysqli_stmt_execute($prepare)) {
        header("location: ../pages/consultarModalidade.php?modalidade_cadastrada=true");
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