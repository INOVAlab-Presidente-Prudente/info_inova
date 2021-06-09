<?php
  $titulo = "Cadastrar Usuario";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
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
            <h1>Cadastrar Usuário</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item "><a href="consultarUsuario.php">Usuários</a></li>
              <li class="breadcrumb-item active">Cadastrar</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    
    
    <section class="content">
      <form method="post" enctype="multipart/form-data">
        <div class="container-fluid">
          <?php 
            if (isset($_POST['confirmar'])) {
                require_once("../admin/CadastroUsuario.php");
            } 
            if (isset($_GET['erro']) && $_GET['erro'] == "cpf_invalido") {
              echo "<div class='col alert alert-warning alert-dismissible'>
                  <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                  <h5><i class='fas fa-exclamation-triangle'></i>&nbspCPF Inválido!</h5>
                  <p>Digite um cpf válido.</p>
                  </div>";
            }
          ?>
          <div class="row">
            <div class="col-md-12">
              <div class="card card-secondary">

                <div class="card-header">
                  <p class="card-title">Dados Pessoais</p>
                </div>
                
                <div class="card-body">
                  <div class="row">                  
                    <div class="col-md-3">
                      <img src="../images/avatar-df.png" class="img-fluid img-thumbnail" id="imgUsuario" alt="User Image">                        
                      <!-- <input type="button" enabled onclick="abrirModal()" value="Tirar Foto"></input> -->
                      <section class="modal-camera" id="modal-camera">
                        <div class="modal-content-camera">
                          <video id="video" autoplay></video>
                          <button type="button" onclick="tirarFoto()">
                            <i class="fas fa-camera-retro"></i>
                          </button>
                          <script>
                              const modalCamera = document.getElementById("modal-camera");
                              function abrirModal(){
                                modalCamera.style.display = "block";
                                startVideoFromCamera();
                              }
                              window.onclick = (e) => {
                                  if (e.target === modalCamera)
                                    modalCamera.style.display = 'none';
                              }
                              function startVideoFromCamera() {
                                  navigator.mediaDevices.getUserMedia({video:{width:320, height:320}}).then(stream=>{
                                      const videoElement = document.querySelector("#video")
                                      videoElement.srcObject = stream
                                  })
                              }
                              function tirarFoto(){
                                const video = document.getElementById("video");
                                const canvas = document.createElement("canvas");
                                // scale the canvas accordingly
                                canvas.width = video.videoWidth;
                                canvas.height = video.videoHeight;
                                // draw the video at that frame
                                canvas.getContext('2d')
                                  .drawImage(video, 0, 0, canvas.width, canvas.height);
                                document.getElementById("imgUsuario").src = canvas.toDataURL();
                                document.getElementById("img64").value = canvas.toDataURL();
                                modalCamera.style.display = 'none';
                              }
                              //window.addEventListener("DOMContentLoaded", startVideoFromCamera())
                          </script>
                        </div>
                      </section>
                      <div class="input-group mt-2">
                          <div class="input-wrapper mx-auto">
                            <input type="hidden" id="img64" name="img64" />
                            <button class="btn btn-secondary btn-md" type="button" onclick="abrirModal()">Tirar
                              Foto</button>
                            <input type="file" name="uploadFoto" id="uploadFoto">
                            <button class="btn btn-secondary btn-md" type="button"
                              onclick="document.getElementById('uploadFoto').click()">Escolha Foto</button>
                          </div>
                        </div>
                        <script>
                          var fileInput1 = document.getElementById('uploadFoto');
                          fileInput1.onchange = function (e) {
                            if (fileInput1.files && fileInput1.files[0]) {
                              var reader = new FileReader();
                              reader.onload = function (e) {
                                $('#imgUsuario').attr('src', e.target.result);
                              }
                              reader.readAsDataURL(fileInput1.files[0]); // convert to base64 string
                            }
                          }
                        </script>
                    </div>
                    <div class="col-md-9">
                      <div class="row">
                        <div class="form-group col-md-12">
                          <label >Nome</label>
                          <input required enabled type="text" name="nome" class="form-control">                        
                        </div>
                        <div class="form-group col-md-8">
                          <label>Email</label>
                          <input required enabled type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Data de Nascimento</label>
                          <input required enabled type="date" id="dataNascimento" onchange="verificaIdade(this)" name="dataNascimento" class="form-control">
                          <input type="hidden" id="idade" name="idade" value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label>CPF</label>
                            <input required enabled pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" id="cpf" type="text" name="cpf" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label>RG</label>
                            <input required enabled type="text" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9a-zA-Z]{1}" minlength="10" maxlength="12" id="rg" name="rg" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                          <label>Telefone(com DDD)</label>
                          <input required enabled type="phone" id="telefone" name="telefone" pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" class="form-control">
                        </div>
                      </div>          
                      <div class="row" id="responsavel" style="display: none;">          
                        <div class="form-group col-md-6">
                            <label>Nome do Responsável</label>
                            <input enabled type="text"  id="nomeResponsavel" name="responsavel" class="form-control" value=''>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Telefone do Responsável</label>
                            <input enabled type="phone" id="telResponsavel" pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" name="telResponsavel" class="form-control" value=''>
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
                          <input required enabled pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9" onpaste="consultaCEP(this.value)" oninput="consultaCEP(this.value)" type="text" id="cep" name="cep" class="form-control">
                        </div>
                        <div class="form-group col-md-7">
                          <label>Endereço</label>
                          <input required enabled type="text" id="endereco" name="endereco" class="form-control">
                        </div>
                        <div class="form-group col-md-1">
                          <label>Número</label>
                          <input required enabled type="text" id="numero" name="numero" class="form-control">
                        </div>
                        <div class="form-group col-md-2">
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
                  <p class="card-title">Outras informações</p>
                </div>
                
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label>Área de Atuação</label>
                      <input required enabled type="text" name="areaAtuacao" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                      <label>Área de Interesse</label>
                      <input required enabled type="text" name="areaInteresse" class="form-control">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-7">
                      <label>Empresa</label>
                      <select name="empresa" class="form-control ">
                        <option value="">...</option>
                        <?php 
                            require_once("../admin/DB.php");
                            $sql = "SELECT * FROM empresa ORDER BY emp_razao_social";
                            $query = mysqli_query($connect, $sql);
                            $res = mysqli_fetch_array($query);
                            while ($res != null) {
                                $nome  = (empty($res['emp_nome_fantasia']))? $res['emp_razao_social'] : $res['emp_nome_fantasia'];
                                echo "<option value='".$res['emp_id']."'>".$nome."</option>";
                                $res = mysqli_fetch_array($query);
                            }
                          ?>
                      </select>
                    </div>
                  
                    <div class="form-group col-md-1 my-auto mx-auto mt-0">
                      <div class="custom-control custom-checkbox">
                        <input enabled class="custom-control-input required" type="checkbox" name="socio" id="socio" enabled >
                        <label class="custom-control-label mt-3" for="socio">Socio</label><br>               
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Perfil de Usuário</label>
                      <select required name="perfil" class="form-control">
                        <?php
                          $sql = "SELECT * FROM perfil_usuario";
                          $query = mysqli_query($connect, $sql);
                          $res2 = mysqli_fetch_array($query);    

                          while ($res2 != null) {
                              if (isset($_SESSION['admin']))
                                  echo "<option value='".$res2['pu_id']."'>". ucwords($res2['pu_descricao']) ."</option>";
                              else if (isset($_SESSION['coworking'])) {
                                  if ($res2['pu_descricao'] != "administrador" && $res2['pu_descricao'] != "financeiro" && $res2['pu_descricao'] != "coworking" && $res2['pu_descricao'] != "evento")
                                      echo "<option value='".$res2['pu_id']."'>". ucwords($res2['pu_descricao']) ."</option>";
                              } 
                              $res2 = mysqli_fetch_array($query);
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="d-flex align-items-center justify-content-center">
                  <input type="checkbox" name="termos">&nbsp;&nbsp;
                  <label class="mt-2" for="termos"><a href="#">Termos de uso</a></label>
                </div>
                <div class="card-footer"> 
                  <div class="row">
                    <button class='col-md-6 offset-md-3 btn btn-primary' name='confirmar'><i class="fas fa-user-check"></i>&nbsp;&nbsp;Salvar Dados do Usuário</button>                
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </section>
  </div>
</div>
  <script src="../js/verificaIdade.js"></script>
  <script src="../js/consultaCep.js"></script>
  <script>
    window.onload = () => carregaEstados("");
    let rg = document.getElementById("rg")
    rg.onfocusout = () => {
      if (rg.value.length == 10)
        rg.value = rg.value + "-X";
    }
  </script>
<?php
  include ('../includes/footer.php');
?>