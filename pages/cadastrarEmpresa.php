<?php
  $title = "Cadastrar Empresa";
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
            <h1>Cadastrar Empresa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin_page.php">Início</a></li>
              <li class="breadcrumb-item "><a href="empresas.php">Empresas</a></li>
              <li class="breadcrumb-item active" >Cadastrar</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Flash message -->
    <?php 
      if (isset($_POST['confirmar'])) {
          require_once("../admin/CadastroEmpresa.php");
      } 
    ?>  
    <!-- /.flash message -->

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
                          <input required enabled onpaste="consultaCNPJ(this.value)" oninput="consultaCNPJ(this.value)" type="text" id="cnpj" name="cnpj" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Telefone</label>
                          <input required enabled type="text" id="telefone" name="telefone" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                          <label>Razão Social</label>
                          <input required enabled type="text" id="razao_social" name="razaoSocial" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Nome Fantasia</label>
                          <input required enabled type="text" id="nome_fantasia" name="nomeFantasia" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Atividade Principal</label>
                          <input required enabled type="text" id="atividade_principal" name="areaAtuacao" class="form-control">
                        </div> 
                      </div>
                      <div class="form-group col-md-12">
                          <label>Modalidade</label>
                          <select required name="modalidade" class="form-control">
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
                  </div>
                </div>

                <div class="card-footer"> 
                  <div class="row">
                    <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class="nav-icon fas fa-briefcase"></i>&nbsp;&nbsp;Salvar Dados da Empresa</button>                
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