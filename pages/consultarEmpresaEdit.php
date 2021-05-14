<?php
  $titulo = "Alterar Empresa";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  require_once("../admin/DB.php");
  $sql = "SELECT * FROM empresa WHERE emp_cnpj = '".$_GET['cnpj']."'";
  $query = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($query);
  
  if (!isset($_GET['alterar']))
      $alterar = 'disabled';
  else
      $alterar = "type='text'";
  
  if($row == NULL){
      header("location: consultarEmpresa.php");
  }            
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <?php
            if(isset($_GET['alterar'])){
              echo "<div class='col-sm-6'>
                <h1>Alterar Empresa</h1>
              </div>";
            }
            else{
              echo "<div class='col-sm-6'>
                <h1>Consultar Empresa</h1>
              </div>";
            }
          ?>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarEmpresa.php">Empresas</a></li>
              <li class="breadcrumb-item active" >Alterar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Flash message -->
    <?php 
        if (isset($_GET['empresa_alterada'])){
            echo "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspEmpresa Alterada!</h5>
                        <p>A empresa foi altrada com sucesso!.</p>
                  </div>";

        }
        if (isset($_GET['empresa_nao_alterada']))
            echo "<div class='container-fluid'>
            <div class='row'>
              <div class='col-md-10 offset-md-1'>
                <div class='alert alert-danger alert-dismissible'>
                  <div class='lead'>
                    <i class='fas fa-times'></i>&nbsp;
                    Dados da empresa não foram alterados. Tente novamente.
                  </div>
                </div>               
              </div>
            </div>
          </div>";
    ?>
    
    <!-- /.flash message -->

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
                        <div class="form-group col-md-6">
                          <label>CNPJ</label>
                          <input required <?=$alterar." value='".$row['emp_cnpj']."'"?> onpaste="consultaCNPJ(this.value)" oninput="consultaCNPJ(this.value)" type="text" id="cnpj" name="cnpj" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Telefone</label>
                          <input required <?=$alterar." value='".$row['emp_telefone']."'"?> type="text" id="telefone" name="telefone" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                          <label>Razão Social</label>
                          <input required <?=$alterar." value='".$row['emp_razao_social']."'"?> type="text" id="razao_social" name="razaoSocial" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Nome Fantasia</label>
                          <input required <?=$alterar." value='".$row['emp_nome_fantasia']."'"?> type="text" id="nome_fantasia" name="nomeFantasia" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Atividade Principal</label>
                          <input required <?=$alterar." value='".$row['emp_area_atuacao']."'"?> type="text" id="atividade_principal" name="areaAtuacao" class="form-control">
                        </div> 
                      
                      <div class="form-group col-md-12">
                          <label>Modalidade</label>
                          <select required <?=$alterar?> name="modalidade" class="form-control">
                          <?php
                            require_once("../admin/DB.php");
                              $sql = "SELECT * FROM modalidade";
                              $query = mysqli_query($connect, $sql);
                              $res = mysqli_fetch_array($query);    

                              while ($res != null) {
                                  if (isset($_SESSION['admin']) || isset($_SESSION['coworking']) || isset($_SESSION['financeiro']))
                                      echo "<option value='".$res['mod_id']."'>". ucwords($res['mod_nome']) ."</option>";
                                  $res = mysqli_fetch_array($query);
                              }
                            ?>
                          </select>
                      </div>
                    </div>
                      <label>Sócios:</label>
                      <?php 
                          $sql = "SELECT u.usu_nome AS nome, u.usu_cpf AS cpf FROM usuario u, empresa e 
                                      WHERE u.emp_id = e.emp_id AND u.usu_socio = 1 AND emp_cnpj = '".$_GET['cnpj']."' ORDER BY u.usu_nome";
                          $query = mysqli_query($connect, $sql);
                          $row2 = mysqli_fetch_assoc($query);

                          while($row2!=null){
                              echo "<div class='col p-1'>";
                              if(in_array(hash("md5", $row2['cpf']).".png", scandir("../images/usuarios")))
                                  echo '<img src="../images/usuarios/'.hash("md5", $row2['cpf']).'.png" class="img-circle elevation-2 mr-1" style="width: 35px; height: 35px" alt="User Image">';
                              else
                                  echo '<img src="../images/avatar-df.png" class="img-circle elevation-2 mr-1" style="width: 35px; height: 35px;" alt="User Image">';
                          
                              echo "<a href='../pages/consultarUsuarioEdit.php?cpf=".$row2['cpf']."'>".$row2['nome']."</a></div>";
                              $row2 = mysqli_fetch_assoc($query);
                          }
                      ?>

                    </div>
                  </div>
                </div>

                <div class="card-footer"> 
                  <div class="row">
                  <?php 
                      if (isset($_GET['alterar'])) {
                          echo "<button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class='fas fa-edit'></i>&nbsp;&nbsp;Salvar Alterações</button>";
                          if (isset($_POST['confirmar'])) {
                              require_once("../admin/AlteraEmpresa.php");
                          }
                      } 
                      else if (isset($_GET['excluir'])) {
                          echo "<button class='btn btn-danger' name='sim'>Sim</button>";
                          echo "<button class='btn btn-light' name='nao'>Nao</button>";
                          if (isset($_POST['sim'])) {
                              require_once("../admin/ExcluiEmpresa.php");
                          }
                          if (isset($_POST['nao']))
                              header("location: ?cnpj=".$row['emp_cnpj']."");
                          
                      }
                      else {
                          echo "<div class='col'> <button name='alterar' class='btn btn-warning w-100'>Alterar</button> </div>";
                          echo "<div id='btn-excluir' name='excluir' class='col btn btn-danger w-100'> Excluir</div>";
                          if (isset($_POST['alterar'])) {
                              header("location: ?cnpj=".$row['emp_cnpj']."&alterar=enabled");
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
  <script>
    function consultaCNPJ(CNPJ){
      CNPJ = CNPJ.replace(/[./-]/g, "")
      if(CNPJ.length==14){
        var script = document.createElement('script');
        script.src = "https://www.receitaws.com.br/v1/cnpj/"+CNPJ+"?callback=meuCallback";
        document.body.appendChild(script);

      }
    }
    function meuCallback(conteudo){
      document.getElementById('razao_social').value=(conteudo.nome);
      if (conteudo.telefone.length > 14)
          conteudo.telefone = conteudo.telefone.split("/")[0]
      document.getElementById('telefone').value=(conteudo.telefone.replace(" ", ""));
      document.getElementById('atividade_principal').value= (conteudo.atividade_principal[0].text);
      document.getElementById('nome_fantasia').value = (conteudo.fantasia);
    }
  </script>
<?php
  include ('../includes/footer.php');
?>