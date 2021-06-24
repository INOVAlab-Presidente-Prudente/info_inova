<?php 
    ob_start();
    session_start();
    
    if (isset($_SESSION['logado'])) {
      header("location: pages/adminPage.php");
    }
    /* header('Access-Control-Allow-Origin: \*'); */
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InfoInova - Login</title>
    <link rel="sortcut icon" href="images/logo_page.png" type="image/x-icon" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#"><b>Info</b>Inova</a>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <div class="container-fluid">
            <div class="mb-2">
              <?php 
                if (isset($_POST['entrar'])) {
                    require_once("admin/Login.php");
                }
              ?>
            </div>
            <p class="login-box-msg">Faça login para iniciar sua sessão</p>
            <form method="post">
              <div class="row justify-content-center">
                
                <div class="col-md-12 input-group mb-3">
                  <input type="text" name="usuario" class="form-control" placeholder="Email ou nome de usuário">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 input-group mb-3">
                  <input type="password" class="form-control" name ="senha" placeholder="Senha">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div id="g-recaptcha" data-sitekey="6LfOv_kaAAAAAEafHopd2IGULE3LDMUH1byxx5ya"></div>
                </div>
                <div class="col-md-12 input-group">
                  <button type="submit" name="entrar" class="btn btn-warning btn-block font-weight-bold text-center mt-2"><i class="fas fa-sign-in-alt mr-2"></i>Login</button>
                </div>
              </div>
            </form>
          </div>          
        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
<?php
    // Desabilita o recaptcha quando em teste no Docker
    if(!getenv('DOCKER_ENV')) {
?>
    <script>
    var onloadCallback = function() {
        grecaptcha.render('g-recaptcha', {
          'sitekey' : '6LfOv_kaAAAAAEafHopd2IGULE3LDMUH1byxx5ya',
          'theme' : 'light'
        })}
    </script>
<?php
    }
?>
  </body>
</html>