<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once('DB.php');
$id = $_GET['res_id'];

$sql2 = "DELETE FROM evento WHERE res_id = ".$id;
$query2 = mysqli_query($connect, $sql2);

$sql = "DELETE FROM reserva_sala WHERE res_id = ".$id;
$query = mysqli_query($connect, $sql);

if($query)
    header("location: /pages/visualizarSala.php?sala_id=".$_GET['sala_id']."&reserva_excluida=true");
else
    header("location: /pages/visualizarSala.php?sala_id=".$_GET['sala_id']."&erro_excluir=true");