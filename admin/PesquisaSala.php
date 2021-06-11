<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once("DB.php");
$sala = $_POST['sala']; 

$sql = "SELECT * FROM sala WHERE sa_nome_espaco LIKE '%".$sala."%'";
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($query);
if (mysqli_num_rows($query)) {
    header("location: ../pages/visualizarSala.php?sala_id=".$row['sa_id']."");
} else {
    header("location: ../pages/consultarSala.php?sala_nao_existe=true");
}