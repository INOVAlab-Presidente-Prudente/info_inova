<?php
  $titulo = "Alterar Modalidade";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");

  require_once('../admin/DB.php');
  $sql = "SELECT * FROM modalidade WHERE mod_id = '".$_GET['mod_id']."'";
  $query = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($query);

  if (!isset($_GET['alterar']))
      $alterar = 'disabled';
  else
      $alterar = "type='text'";
  if($row == null)
      header("location: /pages/consultarModalidade.php");
?>
<div class="content-wrapper">
  
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class='col-sm-6'>
            <h1>Consultar Modalidade</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarModalidade.php">Modalidades</a></li>
              <li class="breadcrumb-item active" >Alterar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Fazer o preenchimento automático dos campos via PHP2 -->
    <section class="content">
      <!-- form start -->
      <form method="post">

        <div class="container-fluid">
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
                        <div class="form-group col-md-1">
                            <label>Código</label>
                            <input <?=$alterar." value='".$row['mod_codigo']."'"?> required type="text" name="codigo" class="form-control">
                        </div>
                        <div class="form-group col-md-11">
                            <label>Nome</label>
                            <input <?=$alterar." value='".$row['mod_nome']."'"?> required type="text" name="nome" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Descricao</label>
                            <input <?=$alterar." value='".$row['mod_descricao']."'"?> required type="text" name="descricao" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Valor Mensal</label>
                            <input <?=$alterar." value='".$row['mod_valMensal']."'"?> pattern="[0-9\.]+" required type="text" name="valorMensal" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Valor Anual</label>
                            <input <?=$alterar." value='".$row['mod_valAnual']."'"?> pattern="[0-9\.]+" required type="text" name="valorAnual" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Edital</label>
                            <input <?=$alterar." value='".$row['mod_edital']."'"?> required type="text" name="edital" class="form-control">
                        </div> 
                    </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer"> 
                  <div class="row">
                    <?php 
                        if (isset($_GET['alterar'])) {
                            echo "<button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class='fas fa-edit'></i>&nbsp;&nbsp;Salvar Alterações</button>";
                            if (isset($_POST['confirmar'])) {
                                require_once("../admin/AlteraModalidade.php");
                            }
                        } 
                        else if (isset($_GET['excluir'])) {
                            echo "<button class='btn btn-danger' name='sim'>Sim</button>";
                            echo "<button class='btn btn-light' name='nao'>Nao</button>";
                            if (isset($_POST['sim'])) {
                                require_once("../admin/ExcluiModalide.php");
                            }
                            if (isset($_POST['nao']))
                                header("location: ?mod_id=".$row['mod_id']."");
                            
                        }
                        else {
                            echo "<div class='col'> <button name='alterar' class='btn btn-warning w-100'>Alterar</button> </div>";
                            echo "<a href='../admin/ExcluiModalidade.php?mod_id=".$row['mod_id']."' id='btn-excluir' name='excluir' class='col btn btn-danger w-100' onclick=\"return confirm('Você realmente quer excluir esse usuário?');\"> Excluir</a>";
                            if (isset($_POST['alterar'])) {
                                header("location: ?mod_id=".$row['mod_id']."&alterar=enabled");
                            }
                            
                        }
                    ?>   
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