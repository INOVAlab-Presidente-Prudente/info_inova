<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once('DB.php');
$id = $_GET['sala_id'];

$sql= "SELECT sa_id FROM sala WHERE sa_id = ".$id;
$query = mysqli_query($connect, $sql);
if(!mysqli_num_rows($query)){
    $sql = "DELETE FROM sala WHERE sa_id = ".$id;
    $query = mysqli_query($connect, $sql);
    if($query)
        header("location: /pages/consultarSala.php?sala_excluida=true"); 
    else
        header("location: /pages/consultarSala.php?erro_excluir=true"); 
}
else
    header("location: /pages/consultarSala.php?exclusao_negada=true"); 
