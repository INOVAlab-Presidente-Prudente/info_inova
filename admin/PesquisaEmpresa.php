<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once("DB.php");
$cnpj = $_POST['cnpj'];

$sql = "SELECT emp_cnpj FROM empresa WHERE emp_cnpj = '".$cnpj."'";
$query = mysqli_query($connect, $sql);
if (mysqli_num_rows($query)) {
    header("location: /pages/consultarEmpresaEdit.php?cnpj=".$cnpj."");
} else 
    header("location: /pages/consultarEmpresa.php?empresa_nao_existe=true");
