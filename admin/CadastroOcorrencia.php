<?php
if(!isset($_SERVER['HTTP_REFERER']))
   header('location: /');

$usu_id = $_GET['usu_id'];
$data = $_POST['dt'];
$hora = $_POST['hora'];
$descricao = $_POST['descricao'];

if(!empty($data) && !empty($hora) && !empty($descricao)){
    require_once("DB.php");

    $sql = "INSERT INTO ocorrencia VALUES (null, ".$usu_id.", '".$data." ".$hora."', '".$descricao."');"; 
    $query = mysqli_query($connect, $sql);

    if ($query) {
        echo "<div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-check'></i>&nbspOcorrência Cadastrada!</h5>
            <p>A ocorrência foi cadastrada com sucesso!.</p>
        </div>";
    } else {
        echo "<div class='alert alert-info alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-info'></i>&nbspOcorrência não Cadastrada!</h5>
            <p>Não foi possível cadastrar a ocorrência, tente novamente!.</p>
        </div>";
    }
} else{
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspNão foi possível cadastar a ocorrência!</h5>
            <p>Preencha todos os campos!.</p>
        </div>";
}



    