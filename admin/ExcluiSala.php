<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once('DB.php');
$id = $_GET['sala_id'];

$sql = "DELETE FROM reserva_sala WHERE sa_id = ".$id;
$query = mysqli_query($connect, $sql);

if($query){

    $sql = "DELETE FROM sala WHERE sa_id = ".$id;
    $query = mysqli_query($connect, $sql);
    if($query)
        header("location: /pages/consultarSala.php?sala_excluida=true"); 
    else{
        echo mysqli_error($connect);
        die();
        header("location: /pages/consultarSala.php?erro_excluir=true");
    }
}else
    echo mysqli_error($connect);




