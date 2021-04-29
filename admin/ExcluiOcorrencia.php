<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once("DB.php");
$sql = "DELETE FROM ocorrencia WHERE oc_id = '".$_GET['oc_id']."'";
$query = mysqli_query($connect, $sql);

if ($query)
    header("location: ../pages/ocorrencias.php?usu_id=".$_GET['usu_id']."&excluido=true");
else 
    header("location: ../pages/ocorrencias.php?usu_id=".$_GET['usu_id']."&erroExcluir=true");