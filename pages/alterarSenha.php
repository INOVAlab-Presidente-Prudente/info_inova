<?php include("../includes/header.php")?>
<body class="hold-transition login-page" onload="document.title='Alterar Senha'">
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
          $sql = "SELECT usu_nomedeusuario FROM usuario WHERE usu_cpf = '".$_SESSION['cpf']."'";
          $query = mysqli_query($connect, $sql);
          $row = mysqli_fetch_assoc($query);
          $nomeUsuario = $row['usu_nomedeusuario'];
          if ($nomeUsuario == NULL):
        ?>
        <!-- Alterar nome de usuario -->
        <p class="login-box-msg">Escolha um nome de usuario</p>
        <form method="post">
          <div class="input-group mb-3">
            <input name="nomeUsuario" type="text" class="form-control" placeholder="Nome">
            <div class="input-group-append">
              <div class="input-group-text">
                <!-- <span class="fas fa-lock"></span> -->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button name="continuar" type="submit" class="btn btn-warning btn-block">Continuar</button>
            </div>
            <!-- /.col -->
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
              }else
                echo "Digite um nome de usuário válido";
          }
      ?>
      <?php else:?>
      <!-- Alterar senha -->
        <p class="login-box-msg">Como é seu primeiro login no InfoInova, é necessário que você faça a alteração da sua senha</p>
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
            <!-- /.col -->
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
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