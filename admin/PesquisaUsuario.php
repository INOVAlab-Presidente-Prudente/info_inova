<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once("DB.php");
$cpf = $_POST['cpf'];

$sql = "SELECT usu_cpf FROM usuario WHERE usu_cpf = '".$cpf."'";
$query = mysqli_query($connect, $sql);
if (mysqli_num_rows($query)) {
    header("location: ../pages/consultarUsuarioEdit.php?cpf=".$cpf."");
} else {
    header("location: ../pages/consultarUsuario.php?usuario_nao_existe=true");
}