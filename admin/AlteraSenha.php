<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: ../');

$novaSenha = $_POST['novaSenha'];
$confirmaSenha = $_POST['confirmaSenha'];

if ($novaSenha == $confirmaSenha) {
    require_once("DB.php");
    $senhaHash = password_hash($novaSenha, PASSWORD_BCRYPT);
    $sql = "UPDATE usuario SET usu_senha = '".$senhaHash."', usu_primeiro_login = 0 WHERE usu_cpf = '".$_SESSION['cpf']."'";
    $query = mysqli_query($connect, $sql);

    if($query)
        header("location: ../pages/adminPage.php?senha_alterada=true");
} else{
    echo "<div class='alert alert-danger alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='icon fas fa-ban'></i>Senhas não coincidem!</h5>
            <p>As senhas não se coicidem, digite novamente.</p>
      </div>"; 
}
