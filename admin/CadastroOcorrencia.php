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
        echo "Ocorrência cadastrada"; //lembrar de colocar o alert
    else
        echo "Não foi possivel cadastrar ocorrência"; //lembrar de colocar o alert
    
    
} else
    echo "Preencha todos os campos"; //lembrar de colocar o alert