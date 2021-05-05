<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');


$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];
$areaAtuacao = $_POST['areaAtuacao'];
$modalidade = $_POST['modalidade'];

if (!empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao) && !empty($modalidade)) {
    require_once("DB.php");
    $sql = "INSERT INTO empresa VALUES (null, '".$razaoSocial."', '".$cnpj."', '".$telefone."', '".$areaAtuacao."', ".$modalidade.")";
    $query = mysqli_query($connect, $sql);
    if ($query) {
        echo "<div class='alert alert-success' role='alert' >Empresa cadastrada </div>"; 
    } else {
        echo "<div class='alert alert-info' role='alert' >Nao foi possivel cadastrar empresa </div>";
    }
} else {
    echo "<div class='alert alert-warning' role='alert'> Preencha todos os campos </div>";
}