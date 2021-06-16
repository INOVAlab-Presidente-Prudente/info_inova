<?php
if(!isset($_SERVER['HTTP_REFERER'])){
    header('location: ../');
}

require_once("DB.php");

$email = $_POST['usuario'];
$nomeUsuario = $_POST['usuario'];
$senha = $_POST['senha'];

$sql = "SELECT usu_nome, usu_senha, pu_id, usu_primeiro_login, usu_cpf, usu_nomedeusuario FROM usuario WHERE usu_email = '".$email."' OR usu_nomedeusuario = '".$nomeUsuario."'";

$query = mysqli_query($connect, $sql);

$fetch = mysqli_fetch_assoc($query);
if ($fetch != null) {
    if (password_verify($senha, $fetch['usu_senha']) && isset($_POST['g-recaptcha-response'])) {
        require_once("SecretKey.php");
        $secretkey = SECRET_KEY;
        $ip = $_SERVER['REMOTE_ADDR'];
        $response = $_POST['g-recaptcha-response'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$response;
        $success = json_decode(file_get_contents($url))->success;

        if ($success) {
            $_SESSION['logado'] = true;
            $_SESSION['cpf'] =  $fetch['usu_cpf'];
            $_SESSION['nome'] =  $fetch['usu_nomedeusuario'];
            
            switch ($fetch['pu_id']) {
                case "1":
                    $_SESSION['admin'] = true;
                    $_SESSION['perfil_usuario'] = "Administrador";
                break;
                case "2":
                    $_SESSION['coworking'] = true;
                    $_SESSION['perfil_usuario'] = "Coworking";
                break;
                case "3":
                    $_SESSION['usuario'] = true;
                    $_SESSION['perfil_usuario'] = "Visitante";
                break;
                case "4":
                    $_SESSION['financeiro'] = true;
                    $_SESSION['perfil_usuario'] = "Financeiro";
                break;
                case "5":
                    $_SESSION['evento'] = true;
                    $_SESSION['perfil_usuario'] = "Evento";
                break;
                case "6":
                    $_SESSION['empresa'] = true;
                    $_SESSION['perfil_usuario'] = "Empresa";
                break;
            }
            if (isset($_SESSION['logado']) && !isset($_SESSION['admin']) && !isset($_SESSION['coworking']) && !isset($_SESSION['financeiro'])){
                session_destroy();
                echo "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-skull-crossbones'></i>&nbspAcesso Negado!</h5>
                        <p class='text-break'>Você não tem acesso ao sistema!.</p>
                </div>";
            }else if ($fetch['usu_primeiro_login']){
                $_SESSION['primeiro_login'] = true;
                header("location: ../pages/alterarSenha.php");
            }else{
                header("location: ../pages/adminPage.php");}
        }
        else{
            echo "<div class='alert alert-danger alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <i class='fas fa-robot'></i></i> Complete o CAPTCHA para entrar!
                </div>";
        }

        
    } else  
        echo "<div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='icon fas fa-ban'></i> Dados Incorretos!</h5>
                    <p class='text-break'>Email ou senha incorretos, verifique e tente novamente.</p>
              </div>";
} else{
    echo "<div class='alert alert-warning alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-exclamation-triangle'></i> Dados Inexistentes!</h5>
                <p class='text-break'>Dados não encontrados no sistema, entre em contato com o administrador do sistema para se cadastrar.</p>
          </div>";
}