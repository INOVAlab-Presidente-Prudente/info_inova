<?php include("../includes/header.php") ?>
<body class="hold-transition login-page" onload="document.title='Alterar Senha'">
  <div class="login-box">
    <div class="login-logo">
      <a href="/"><b>Info</b>Inova</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Como é seu primeiro login no InfoInova, é necessário que você faça a alteração da sua senha</p>

        <form  method="post">
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
          <?php 
            if (isset($_POST['alterarSenha'])) {
                require_once("../admin/AlteraSenha.php");
            }
          ?>
        </form>

        <p class="mt-3 mb-1">
          <a href="/">Ir para a HomePage</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

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