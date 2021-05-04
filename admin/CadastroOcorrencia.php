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

    if($query)
        echo "<div class='alert alert-success' role='alert'>Ocorrência cadastrada</div>"; //lembrar de colocar o alert
    else
        echo "<div class='alert alert-info' role='alert'> Não foi possivel cadastrar ocorrência</div>"; //lembrar de colocar o alert
    
    
} else
    echo "<div class='alert alert-waning' role='alert'>Preencha todos os campos</div>"; //lembrar de colocar o alert