<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once('DB.php');
$id = $_GET['mod_id'];

$sql= "SELECT emp_id FROM empresa WHERE mod_id = ".$id;
$query = mysqli_query($connect, $sql);
if(!mysqli_num_rows($query)){
    $sql = "DELETE FROM modalidade WHERE mod_id = ".$id;
    $query = mysqli_query($connect, $sql);
    if($query)
        header("location: /pages/consultarModalidade.php?modalidade_excluida=true"); 
    else
        header("location: /pages/consultarModalidade.php?erro_excluir=true"); 
}
else
    header("location: /pages/consultarModalidade.php?exclusao_negada=true"); 



