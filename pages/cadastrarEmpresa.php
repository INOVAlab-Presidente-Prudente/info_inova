<?php
  $titulo = "Cadastrar Empresa";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ("../includes/primeirologin.php");
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');
?>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cadastrar Empresa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarEmpresa.php">Empresas</a></li>
              <li class="breadcrumb-item active" >Cadastrar</li>
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
                require_once("../admin/CadastroEmpresa.php");
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
                        <div class="form-group col-md-3">
                          <label>CNPJ</label>
                          <input required enabled onpaste="consultaCNPJ(this.value)" oninput="consultaCNPJ(this.value)" type="text" id="cnpj" name="cnpj" class="form-control">
                        </div>
                        <div class="form-group col-md-9">
                            <label>Email</label>
                          <input required enabled type="email" id="email" name="email" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>Telefone</label>
                          <input required enabled type="text" id="telefone" name="telefone" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Razão Social</label>
                          <input required enabled type="text" id="razao_social" name="razaoSocial" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Nome Fantasia</label>
                          <input required enabled type="text" id="nome_fantasia" name="nomeFantasia" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                          <label>Atividade Principal</label>
                          <input required enabled type="text" id="atividade_principal" name="areaAtuacao" class="form-control">
                        </div> 
                      </div>
                                            
                      <div class="form-group col-md-12">
                        <div class="row">
                          <div class="col-md-2 my-auto">
                            <div class="custom-control custom-checkbox">
                              <input enabled onclick="residenteCheck(this)" class="custom-control-input required" type="checkbox" name="residente" id="residente">
                              <label class="custom-control-label" for="residente">Residente</label><br>               
                            </div>
                          </div>
                          
                          <div class="col-md-9" id="modalidade-content" style="display: none">
                            <label>Modalidade</label>
                            <div class="row ">
                              <select required name="modalidade" id="modalidade" class="form-control col-11 w-100">
                                <?php
                                  require_once("../admin/DB.php");
                                  $sql = "SELECT * FROM modalidade";
                                  $query = mysqli_query($connect, $sql);
                                  $res = mysqli_fetch_array($query);    
                                  while ($res != null) {
                                      if (isset($_SESSION['admin']) || isset($_SESSION['coworking']) || isset($_SESSION['financeiro']))
                                          echo "<option descricao='".$res['mod_descricao']."' value='".$res['mod_id']."'>". ucwords($res['mod_nome']) ."</option>";
                                      $res = mysqli_fetch_array($query);
                                  }
                                ?>
                              </select> 
                              <div class="align-itens-center justify-content-end">
                                <button type="button" class="btn btn-dark ml-1" id="example" data-toggle="tooltip" data-placement="top" >
                                  <i class="far fa-question-circle w-100"></i>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid">
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
                            <input required enabled pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9" onpaste="consultaCEP(this.value)" onchange="consultaCEP(this.value)" oninput="consultaCEP(this.value)" type="text" id="cep" name="cep" class="form-control">
                          </div>
                          <div class="form-group col-md-7">
                            <label>Endereço</label>
                            <input required enabled type="text" id="endereco" name="endereco" class="form-control">
                          </div>
                          <div class="form-group col-md-3">
                            <label>Complemento</label>
                            <input enabled type="text" id="complemento" name="complemento" class="form-control">
                          </div>
                          <div class="form-group col-md-4">
                            <label>Bairro</label>
                            <input required enabled type="text" id="bairro" name="bairro" class="form-control">
                          </div>
                          <div class="form-group col-md-5">
                            <label>Município</label>
                            <input required enabled type="text" id="municipio" name="municipio" class="form-control">
                          </div>                      
                          <div class="form-group col-md-3">
                            <label>Estado</label>
                            <select name="estado" id="estado" class="form-control">                              
                              <option selected disabled value="">Selecione um estado</option>
                            </select>
                          </div>
                        </div>
                        <div class="row">
                          <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class="nav-icon fas fa-briefcase"></i>&nbsp;&nbsp;Salvar Dados da Empresa</button> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
  </div>
  <script src="../js/consultaCep.js"></script>
  <script>
    window.onload = () => carregaEstados("");

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    $('#example').hover(function(){
      $('#example').prop("title",$("#modalidade").children("option:selected")[0].attributes[0].textContent);
    })


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
      document.getElementById('cep').value = (conteudo.cep.replace(".", ""));
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