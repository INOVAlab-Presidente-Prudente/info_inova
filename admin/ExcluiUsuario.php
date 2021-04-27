<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

session_start();
require_once('DB.php');
$cpf = $_GET['cpf'];
$sql = "SELECT usu_id, pu_id, usu_cpf FROM usuario WHERE usu_cpf = '".$cpf."'";
$query = mysqli_query($connect, $sql);
$fetch = mysqli_fetch_assoc($query);

$usu_id = $fetch['usu_id'];
$pu_id = $fetch['pu_id'];
$cpf = $fetch['usu_cpf'];
    
if (($pu_id == '1' && !isset($_SESSION['admin'])) || ($pu_id == '2' && !isset($_SESSION['admin']) && $cpf != $_SESSION['cpf']))
    header("location: /pages/consultaUsers.php?erro=permissao_negada");
else {
    $sql = "DELETE FROM check_in WHERE usu_id = '".$usu_id."'";
    $query = mysqli_query($connect, $sql);

    $sql = "DELETE FROM ocorrencia WHERE usu_id = '".$usu_id."'";
    $query = mysqli_query($connect, $sql);

    if ($cpf == $_SESSION['cpf']) {
        session_destroy();
    }

    $sql = "DELETE FROM usuario WHERE usu_id = '".$usu_id."'";
    $query = mysqli_query($connect, $sql);
    header("location: /pages/consultaUsers.php?usuario_excluido=true");
}