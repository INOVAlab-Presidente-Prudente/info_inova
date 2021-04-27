<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: /');
}

require_once("DB.php");

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT usu_nome, usu_senha, pu_id, usu_primeiro_login, usu_cpf FROM usuario WHERE usu_email = '".$email."'";

$query = mysqli_query($connect, $sql);

$fetch = mysqli_fetch_assoc($query);

if ($fetch != null) {
    if (password_verify($senha, $fetch['usu_senha'])) {
        $_SESSION['logado'] = true;
        $_SESSION['cpf'] =  $fetch['usu_cpf'];
        $_SESSION['nome'] =  $fetch['usu_nome'];
        
        switch ($fetch['pu_id']) {
            case "1":
                $_SESSION['admin'] = true;
            break;
            case "2":
                $_SESSION['coworking'] = true;
            break;
            case "3":
                $_SESSION['usuario'] = true;
            break;
            case "4":
                $_SESSION['financeiro'] = true;
            break;
            case "5":
                $_SESSION['evento'] = true;
            break;
            case "6":
                $_SESSION['empresa'] = true;
            break;
        }

        if (isset($_SESSION['logado']) && !isset($_SESSION['admin']) && !isset($_SESSION['coworking']) && !isset($_SESSION['financeiro'])){
            session_destroy();
            echo "<small style='font-color: red'>Acesso negado.</small>";
        }else if ($fetch['usu_primeiro_login']){
            header("location: pages/alterarSenha.php");
        }else{
            header("location: pages/adminPage.php");}
    } else  
        echo "<small style='font-color: red'>E-mail ou senha invalidos.</small>";
} else
    echo "<small style='font-color: red'>E-mail ou senha invalidos.</small>";