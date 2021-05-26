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
  if($row == NULL){
      header("location: consultarEmpresa.php");
  }            
?>
<div class="content-wrapper">
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
      </div>
    </section>
    <section class="content">
      <form method="post">

        <div class="container-fluid">
          <?php 
            if (isset($_GET['empresa_nao_alterada'])){
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='icon fas fa-ban'></i> Empresa não alterada!</h5>
                            <p>Empresa não foi alterada.</p>
                      </div>";
            }
            if (isset($_GET['falta_dados'])){
              echo "<div class='alert alert-danger alert-dismissible'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h5><i class='icon fas fa-ban'></i> Empresa não alterada!</h5>
                          <p>Preencha todos os campos.</p>
                    </div>";
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
                        <div class="form-group col-md-4">
                          <label>CNPJ</label>
                          <input required value='<?=$row['emp_cnpj']?>' onpaste="consultaCNPJ(this.value)" oninput="consultaCNPJ(this.value)" type="text" id="cnpj" name="cnpj" class="form-control">
                        </div>
                        <div class="form-group col-md-8">
                            <label>Email</label>
                          <input required value='<?=$row['emp_email']?>' type="text" id="email" name="email" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Telefone</label>
                          <input required value='<?=$row['emp_telefone']?>' type="text" id="telefone" name="telefone" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Razão Social</label>
                          <input required value='<?=$row['emp_razao_social']?>' type="text" id="razao_social" name="razaoSocial" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Nome Fantasia</label>
                          <input required value='<?=$row['emp_nome_fantasia']?>' type="text" id="nome_fantasia" name="nomeFantasia" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Atividade Principal</label>
                          <input required value='<?=$row['emp_area_atuacao']?>' type="text" id="atividade_principal" name="areaAtuacao" class="form-control">
                        </div> 
                      
                        <div class="form-group col-md-12">
                          <div class="row">
                            <div class="col-2 my-auto">
                              <div class="custom-control custom-checkbox">
                                <input <?=$row['emp_residente'] ?"checked":""; ?>  
                                onclick="residenteCheck(this)" class="custom-control-input required" 
                                type="checkbox" name="residente" id="residente">
                                <label class="custom-control-label" for="residente">Residente</label><br>               
                              </div>
                            </div>
                            <div class="col-10" id="modalidade-content" style="display: <?=$row['emp_residente'] ? "block" : "none"?>">
                              <label>Modalidade</label>
                              <select name="modalidade" class="form-control">
                              <?php
                                require_once("../admin/DB.php");
                                  $sql = "SELECT * FROM modalidade";
                                  $query = mysqli_query($connect, $sql);
                                  $res = mysqli_fetch_array($query);    

                                  while ($res != null) {
                                      if (isset($_SESSION['admin']) || isset($_SESSION['coworking']) || isset($_SESSION['financeiro']))
                                        if ($res['mod_id'] == $row['mod_id'])
                                          echo "<option selected value='".$res['mod_id']."'>". ucwords($res['mod_nome']) ."</option>";
                                        else
                                          echo "<option value='".$res['mod_id']."'>". ucwords($res['mod_nome']) ."</option>";
                                      $res = mysqli_fetch_array($query);
                                  }
                                ?>
                              </select>
                            </div>
                          </div>
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

              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card card-secondary">

                <div class="card-header">
                  <p class="card-title">Endereço</p>
                </div>

                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                    <div class="row">
                          <div class="form-group col-md-2">
                            <label>CEP</label>
                            <input value='<?=$row['emp_cep']?>' required enabled pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9" onpaste="consultaCEP(this.value)" oninput="consultaCEP(this.value)" type="text" id="cep" name="cep" class="form-control">
                          </div>
                          <div class="form-group col-md-7">
                            <label>Endereço</label>
                            <input value='<?=$row['emp_endereco']?>' required enabled type="text" id="endereco" name="endereco" class="form-control">
                          </div>
                          <div class="form-group col-md-3">
                            <label>Complemento</label>
                            <input value='<?=$row['emp_complemento']?>' enabled type="text" id="complemento" name="complemento" class="form-control">
                          </div>
                          <div class="form-group col-md-4">
                            <label>Bairro</label>
                            <input value='<?=$row['emp_bairro']?>' required enabled type="text" id="bairro" name="bairro" class="form-control">
                          </div>
                          <div class="form-group col-md-5">
                            <label>Município</label>
                            <input value='<?=$row['emp_municipio']?>' required enabled type="text" id="municipio" name="municipio" class="form-control">
                          </div>                      
                          <div class="form-group col-md-3">
                            <label>Estado</label>
                            <select name="estado" id="estado" class="form-control">                              
                              <option selected disabled value="">Selecione um estado</option>
                            </select>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer"> 
                  <div class="row">
                  <?php 
                          echo "<button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class='fas fa-edit'></i>&nbsp;&nbsp;Salvar Alterações</button>";
                          if (isset($_POST['confirmar'])) {
                              require_once("../admin/AlteraEmpresa.php");
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
  <script src="../js/consultaCep.js"></script>
  <script>
    window.onload = () => carregaEstados('<?=$row['emp_estado']?>');
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
      document.getElementById('cep').value = (conteudo.cep);
      document.getElementById('endereco').value = (conteudo.logradouro);
      document.getElementById('complemento').value = (conteudo.complemento);
      document.getElementById('bairro').value = (conteudo.bairro);
      document.getElementById('municipio').value = (conteudo.municipio);
      document.getElementById('estado').value = (conteudo.uf);
      document.getElementById('email').value = (conteudo.email);
    }
    function residenteCheck(button){
      var content = document.getElementById('modalidade-content');
      if(button.checked == true)
        content.style.display = "block";
      else
        content.style.display = "none";
    }
  </script>
<?php
  include ('../includes/footer.php');
?>