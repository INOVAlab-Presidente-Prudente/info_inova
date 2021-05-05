<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: ../');
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
        $nome = explode(" ", $fetch['usu_nome'])[0];
        $sobrenome = explode(" ", $fetch['usu_nome'])[count(explode(" ", $fetch['usu_nome']))-1];
        $_SESSION['nome'] =  $nome . " " . $sobrenome;
        
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
            header("location: ../pages/alterarSenha.php");
        }else{
            header("location: ../pages/adminPage.php");}
    } else  
        echo "<div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='icon fas fa-ban'></i> Dados Incorretos!</h5>
                    <p>Senha ou email incorretos, verifique o que você digitou e tente novamente.</p>
              </div>";
} else{
    echo "<div class='alert alert-warning alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-exclamation-triangle'></i> Dados Inexistentes!</h5>
                <p>Dados não encontrados no sistema, entre em contato com o administrador do sistema para se cadastrar.</p>
          </div>";
}