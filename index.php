<?php 
    ob_start();
    session_start();
    if (isset($_SESSION['logado'])) {
      header("location: pages/adminPage.php");
    }
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
  
</head>
<body class="hold-transition login-page">

<script type="text/javascript">
    
    /*var verifyCallback = function(response) {
        var URL_TO_FETCH = 'https://www.google.com/recaptcha/api/siteverify?secret=&response='+ response;
      
        $.post(URL_TO_FETCH).done(function(result){
            console.log(result);
        });
        
        const resultFectch = fetch(URL_TO_FETCH, {method:'POST', mode:'no-cors', 
            header: {'Accept': 'application/json', 'Content-Type': 'application/json'},
            body: JSON.stringify({secret:'', response:response})
        }).then(function(resposta){
            console.log(resposta);
        }).catch(function(error){
            console.log("Response reCAPTCHA error: " + error.toString());
        });
        
        console.log(resultFectch);
    };
    
    var errorCallback = function(response){
        
    };*/
    
    /*var onloadCallback = function() {
        grecaptcha.render('g-recaptcha', {
          'sitekey' : '',
          'theme' : 'light',
          /*'callback' : verifyCallback,
          'error-callback' : errorCallback*/
        });
    };*/
  </script>
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Info</b>Inova</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
    
      <div class="card-body login-card-body">
        <div class="mb-2">
          <?php 
            if (isset($_POST['entrar'])) {
                require_once("admin/Login.php");
            }
          ?>
        </div>
        
        <p class="login-box-msg">Faça login para iniciar sua sessão</p>

        <form method="post">
          <div class="input-group mb-3">
            <input type="email" name = "email" class="form-control" placeholder="example@email.com">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name ="senha" placeholder="Senha">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col w-100">
            <div class="col w-100 mx-auto">
                <div id="g-recaptcha"></div>
              </div>
            <br>
              <button type="submit" name="entrar" class="btn btn-warning btn-block fo">Login</button>
            </div>
            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer></script>
            
            
          </div>
        </form>
        
    </div>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>
  <script>
    function onSubmit(token) {
      document.getElementById("demo-form").submit();
    }
 </script>
  
</body>
</html>