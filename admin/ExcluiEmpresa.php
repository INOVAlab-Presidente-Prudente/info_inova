<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once('DB.php');
$cnpj = $_GET['cnpj'];
$sql = "SELECT emp_id FROM empresa WHERE emp_cnpj = '".$cnpj."'";
$query = mysqli_query($connect, $sql);

$emp_id = mysqli_fetch_assoc($query)['emp_id'];

$sql = "UPDATE usuario SET emp_id = null, usu_socio = null WHERE emp_id = ".$emp_id."";
$query = mysqli_query($connect, $sql);

$sql = "DELETE FROM empresa WHERE emp_id = '".$emp_id."'";
$query = mysqli_query($connect, $sql);

header("location: /pages/consultarEmpresa.php?empresa_excluida=true"); 