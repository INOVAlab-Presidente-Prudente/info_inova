<?php
  $titulo = "Home Page";
  include ('../includes/header.php');
  include ("../includes/primeirologin.php");
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
      </div>
    </section>
    <section class="content">
        <div class="container-fluid">
        <?php 
            if (isset($_GET['senha_alterada']))
                echo "<div class='alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-check'></i>&nbspSenha Alterada!</h5>
                            <p>Senha alterada com sucesso!.</p>
                      </div>";
          ?>
          <div class="row">
            <div class="col-12">
              <div class="callout callout-info">
                <h3>Olá, <?=$_SESSION['nome']?></h3>
                <p class="lead">Seja bem-vindo ao InfoInova.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
  </div>
<?php
  include ('../includes/footer.php');
?>