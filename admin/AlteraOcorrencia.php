<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$data = $_POST['dt'];
$hora = $_POST['hora'];
$descricao = $_POST['descricao'];
$oc_id = $_POST['oc_id'];
$usu_id = $_POST['usu_id'];
var_dump($_POST['usu_id']);

require_once("DB.php");

$sql = "UPDATE ocorrencia SET oc_data = '".$data." ".$hora."', oc_descricao='".$descricao."'  WHERE oc_id=".$oc_id.";";
$query = mysqli_query($connect,$sql);

if($query)
    header("location: ../pages/ocorrencias.php?usu_id=".$usu_id."");
else
    echo "Erro ao tentar alterar a ocorrência";
