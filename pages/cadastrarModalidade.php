<?php
  $titulo = "Cadastrar Modalidade";
  include ('../includes/header.php');
  include ("../includes/primeirologin.php");
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cadastrar Modalidade</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarModalidade.php">Modalidades</a></li>
              <li class="breadcrumb-item active">Cadastrar</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <form method="post">
        <div class="container-fluid">
          <?php 
            if (isset($_POST['confirmar'])) {
                require_once("../admin/CadastroModalidade.php");
            } 
          ?> 
          <div class="row">
            <div class="col-md-12">
              <div class="card card-secondary">

                <div class="card-header">
                  <p class="card-title">Dados Cadastrais</p>
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="form-group col-md-12">
                            <label>Nome</label>
                            <input required type="text" name="nome" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Descrição</label>
                            <input required type="text" name="descricao" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Valor Mensal</label>
                            <input required type="text" pattern="[0-9\.]+" name="valorMensal" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Valor Anual</label>
                            <input required type="text" pattern="[0-9\.]+" name="valorAnual" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Edital</label>
                            <input required type="text" name="edital" class="form-control">
                        </div>
                     </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer"> 
                  <div class="row">
                    <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class="nav-icon fas fa-briefcase"></i>&nbsp;&nbsp;Salvar Dados da Modalidade</button>                
                  </div> 
                </div>
                
              </div>
            </div>
          </div>
        </div>

      </form>
    </section>
    <!-- /.content -->
  </div>
<?php
  include ('../includes/footer.php');
?>