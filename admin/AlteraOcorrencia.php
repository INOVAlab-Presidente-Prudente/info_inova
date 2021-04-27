<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$data = $_POST['dt'];
$hora = $_POST['hora'];
$descricao = $_POST['descricao'];
$oc_id = $_GET['oc_id'];

require_once("DB.php");

$sql = "UPDATE ocorrencia SET oc_data = '".$data." ".$hora."', oc_descricao='".$descricao."'  WHERE oc_id=".$oc_id.";";
$query = mysqli_query($connect,$sql);

if($query)
    header ("Location: ocorrencias.php?usu_id=".$_GET['usu_id']."");
else
    echo "Erro ao tentar alterar a ocorrência";
