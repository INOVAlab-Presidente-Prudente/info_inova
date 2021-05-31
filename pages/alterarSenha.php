<?php 
    ob_start();
    session_start();
    if (!isset($_SESSION['logado'])) 
    {
        header("location: ../");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Senha</title>
    
    <link rel="sortcut icon" href="../images/logo_page.png" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/"><b>Info</b>Inova</a>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <?php 
            if (isset($_POST['alterarSenha'])) 
                require_once("../admin/AlteraSenha.php");
            require_once("../admin/DB.php");
            $sql = "SELECT usu_nomedeusuario, usu_primeiro_login FROM usuario WHERE usu_cpf = '".$_SESSION['cpf']."'";
            $query = mysqli_query($connect, $sql);
            $row = mysqli_fetch_assoc($query);
            $nomeUsuario = $row['usu_nomedeusuario'];
            if ($nomeUsuario == NULL):
          ?>
          <!-- Alterar nome de usuario -->
          <p class="login-box-msg">Escolha um nome de usuario</p>
          <form method="post">
            <div class="input-group mb-3">
              <input name="nomeUsuario" pattern="(?=[a-zA-Z0-9._]{4,50}$)(?!.*[_-]{2})[^_.]*[^_.]" type="text" class="form-control" placeholder="Nome">
              <div class="input-group-append">
                <div class="input-group-text">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 w-100">
                <button name="continuar" type="submit" class="btn btn-warning btn-block fo">Continuar</button>
              </div>
            </div>
          </form>
        </div>
        <?php 
            if (isset($_POST['continuar'])) {
                $sql = "UPDATE usuario SET usu_nomedeusuario = '".$_POST['nomeUsuario']."' WHERE usu_cpf = '".$_SESSION['cpf']."'";
                $query = mysqli_query($connect, $sql);
                if ($query) {
                  $_SESSION['nome'] = $_POST['nomeUsuario'];
                  header("location: /pages/alterarSenha.php");
                }
                else{
                  echo "<div class='col alert alert-warning alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-exclamation-triangle'></i>&nbspNome de Usuário inválido!</h5>
                    <p>O nome de usuário é muito grande, tente novamente.</p>
                  </div>";
                }
                  
            }
        ?>
        <?php else:?>
        <!-- Alterar senha -->
        <?php
          if($_SESSION['usu_primeiro_login'])
            echo "<p class='login-box-msg'>Como é seu primeiro login no InfoInova, é necessário que você faça a alteração da sua senha</p>";
          else{
            echo "<p class='login-box-msg'>Altere sua Senha</p>";
          }
        ?>  
          <form method="post">
            <div class="input-group mb-3">
              <input name="novaSenha" type="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input name="confirmaSenha" type="password" class="form-control" placeholder="Confirm Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button name="alterarSenha" type="submit" class="btn btn-warning btn-block">Alterar Senha</button>
              </div>
            </div>
          </form>
          <?php if (!$_SESSION['primeiro_login']):?>
            <p class="mt-3 mb-1">
              <a href="../">Ir para a HomePage</a>
            </p>
          <?php endif;?>
        </div>
      </div>
    </div>
    <?php endif?>

      <!-- jQuery -->
      <script src="../plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- AdminLTE App -->
      <script src="../dist/js/adminlte.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="../dist/js/demo.js"></script>
      <!-- My Scripts -->
      <script src="../js/scripts.js"></script>
  </body>
</html> 