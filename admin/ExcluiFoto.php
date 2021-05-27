<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once('DB.php');

$cpf = $_GET['cpf'];

$hashCPF = hash("md5", $cpf);

if(in_array(hash("md5", $cpf).".png", scandir("../images/usuarios"))){
    if(unlink("../images/usuarios/".$hashCPF.".png")){
        header("location: /pages/consultarUsuarioEdit.php?cpf=".$cpf."&fotoExcluida=true");
    }
    else{
        header("location: /pages/consultarUsuarioEdit.php?cpf=".$cpf."&fotoExcluida=false");
    }
}    
else{
    header("location: /pages/consultarUsuarioEdit.php?cpf=".$cpf."&fotoNaoExistente=true");
}

