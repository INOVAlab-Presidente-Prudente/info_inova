<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$nomefantasia = $_POST['nomefantasia'];
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];
$areaAtuacao = $_POST['areaAtuacao'];
$modalidade = $_POST['modalidade'];

if (!empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao) && !empty($modalidade)) {
    require_once("DB.php");
    $sql = "INSERT INTO empresa VALUES (null, '".$razaoSocial."', '".$cnpj."', '".$telefone."', '".$areaAtuacao."', ".$modalidade.", 0, '".$nomefantasia."')";
    $query = mysqli_query($connect, $sql);
    if ($query) {
        echo "<div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-check'></i>&nbspEmpresa Cadastrada!</h5>
            <p>A empresa foi cadastrada com sucesso!.</p>
        </div>";
    } else {
        if(str_contains(mysqli_error($connect), "Duplicate entry")){
            echo "<div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-info'></i>&nbspEmpresa já Cadastrada!</h5>
                <p> Este CNPJ já encontra-se cadastrado no sistema</p>
            </div>";
        }
        else 
            echo "<div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-info'></i>&nbspEmpresa não Cadastrada!</h5>
                <p>Não foi possível cadastrar a empresa, tente novamente!.</p>
            </div>";
    }
} else {
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspNão foi possível cadastar a empresa!</h5>
            <p>Preencha todos os campos!.</p>
         </div>";
}

