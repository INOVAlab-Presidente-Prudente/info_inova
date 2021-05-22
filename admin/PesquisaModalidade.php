<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once("DB.php");
$modalidade = $_POST['modalidade']; // nome da modalidade

$sql = "SELECT * FROM modalidade WHERE mod_nome LIKE '%".$modalidade."%'";
$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($query);
if (mysqli_num_rows($query)) {
    header("location: ../pages/visualizarModalidade.php?mod_id=".$row['mod_id']."");
} else {
    header("location: ../pages/consultarModalidade.php?modalidade_nao_existe=true");
}