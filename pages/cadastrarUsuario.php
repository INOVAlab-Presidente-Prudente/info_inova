<?php include('../includes/header.php');?>
<?php include("../includes/primeirologin.php");?>
<?php include('../includes/permissoes.php');?>

<body class="hold-transition sidebar-mini" onload="document.title=' Cadastrar Usuario'">

  <?php include('../includes/navbar.php'); ?>

  <?php include("../includes/sidebar.php");?>
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Cadastro de Usuários</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                <li class="breadcrumb-item active">Cadastro de Usuários</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left  -->
            <div class="col-lg-12">
              <!-- jquery validation -->
              <div class="card card-primary">

                <!-- /.card-header -->
                <!-- form start -->
                <form id="quickForm" method='post' enctype="multipart/form-data">
                  <div class="card-header">
                    <?php 
                    if (isset($_POST['cadastrar'])) {
                        require_once("../admin/CadastroUsuario.php");
                    } 
                  ?>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-lg-3 col-md-4 order-lg-1 mx-auto">
                        <div class="d-flex justify-content-center">
                          <img src="../images/avatar-df.png" class="img-fluid img-thumbnail" id="imgUsuario" alt="">
                        </div>
                        <input type="hidden" id="img64" name="img64" />
                        <section class="modal-camera" id="modal-camera">
                          <div class="modal-content">
                            <video id="video" autoplay></video>
                            <button type="button" onclick="tirarFoto()">
                              <i class="fas fa-camera-retro"></i>
                            </button>
                            <script>
                              const modal = document.getElementById("modal-camera");

                              function abrirModal() {
                                modal.style.display = "block";
                                startVideoFromCamera();
                              }
                              window.onclick = (e) => {
                                if (e.target === modal)
                                  modal.style.display = 'none';
                              }

                              function startVideoFromCamera() {
                                navigator.mediaDevices.getUserMedia({
                                  video: {
                                    width: 320,
                                    height: 320
                                  }
                                }).then(stream => {
                                  const videoElement = document.querySelector("#video")
                                  videoElement.srcObject = stream
                                })
                              }

                              function tirarFoto() {
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
                                modal.style.display = 'none';
                              }
                              //window.addEventListener("DOMContentLoaded", startVideoFromCamera())
                            </script>
                          </div>
                        </section>
                        <div class="input-group">
                          <div class="input-wrapper mx-auto">
                            <!-- <div class="container my-auto mx-auto"> -->
                            <input type="hidden" id="img64" name="img64" />
                            <button class="btn btn-secondary btn-md" type="button" onclick="abrirModal()">Tirar
                              Foto</button>
                            <input type="file" name="uploadFoto" id="uploadFoto">
                            <button class="btn btn-secondary btn-md" type="button"
                              onclick="document.getElementById('uploadFoto').click()">Escolha Foto</button>
                            <!-- </div> -->
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
                      <div class="col-lg-9">
                        <div class="col-lg-12">
                          <div class="form-group ">
                            <label>Nome</label>
                            <input required type="text" name="nome" class="form-control" placeholder="">
                          </div>
                        </div>

                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>CPF</label>
                                <input required pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14"
                                  maxlength="14" type="text" id="cpf" name="cpf" class="form-control"
                                  placeholder="xxx.xxx.xxx-xx">
                              </div>
                            </div>

                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>RG</label>
                                <input required pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9a-zA-Z]{1}" minlength="12"
                                  maxlength="12" type="text" id="rg" name="rg" class="form-control"
                                  placeholder="xx.xxx.xxx-x">
                              </div>
                            </div>

                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Data de Nascimento</label>
                                <input required type="date" onchange="verificaIdade(dtNasc)" id="dtNasc"
                                  name="dataNascimento" class="form-control">
                                <input type="hidden" name="idade" id="idade" value="" />
                              </div>
                            </div>
                          </div>
                        
                        <div id="responsavel" style="display: none;">
                          <div class="row">
                            <div class="col-lg-7">
                                <div class="form-group">
                                  <label>Nome do Responsável</label>
                                  <input type="text" id="nomeResponsavel" name="responsavel" class="form-control">
                                </div>
                              </div>
                              
                              <div class="col-lg-5">
                                <div class="form-group">
                                  <label>Telefone do Responsável</label>
                                  <input pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14"
                                    type="phone" id="telResponsavel" name="telResponsavel" class="form-control"
                                    placeholder="(xx)xxxxx-xxxx">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-lg-3">
                              <div class="form-group">
                                <label>CEP</label>
                                <input required pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9"
                                  onpaste="consultaCEP(this.value)" oninput="consultaCEP(this.value)" type="text"
                                  id="cep" name="cep" class="form-control" placeholder="xxxxx-xxx">
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="form-group">
                                <label>Município</label>
                                <input required type="text" id="municipio" name="municipio" class="form-control"
                                  placeholder="Municipio">
                              </div>
                            </div>

                            <div class="col-lg-5">
                              <div class="form-group ">
                                <label>Bairro</label>
                                <input required type="text" id="bairro" name="bairro" class="form-control"
                                  placeholder="Bairro">
                              </div>
                            </div>

                            <div class="col-lg-12">
                              <div class="form-group">
                                <label>Endereço</label>
                                <input required type="text" id="endereco" name="endereco" class="form-control"
                                  placeholder="">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--nome -->

                    <div class="container-fluid">

                      <div class="row">
                        <div class="col-lg-8">
                          <div class="form-group">
                            <label>Email</label>
                            <input required type="email" name="email" class="form-control"
                              placeholder="example@email.com">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>Telefone(com DDD)</label>
                            <input required pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13"
                              maxlength="14" type="phone" id="telefone" name="telefone" class="form-control"
                              placeholder="(xx)xxxxx-xxxx">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Área de Atuação</label>
                            <input required type="text" name="areaAtuacao" class="form-control" placeholder="">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Área de Interesse</label>
                            <input required type="text" name="areaInteresse" class="form-control" placeholder="">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-7">
                          <div class="form-group ">
                            <label>Empresa</label>
                            <select required name="empresa" class="form-control ">
                              <option>...</option>
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
                        </div>

                        <div class="col-lg-1 d-flex">
                          <div class="form-group my-auto">
                            <div class="custom-control custom-checkbox">
                              <input class="custom-control-input required" type="checkbox" name="socio" id="socio">
                              <label class="custom-control-label mt-3" for="socio">Socio</label><br>
                            </div>
                          </div>
                        </div>

                        <div class="col-lg-4">
                          <div class="form-group">
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
                      </div> <!-- row da empresa -->
                    </div>
                  </div> <!-- fluid do emai -->
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                  </div>
              </div>
              </form>
            </div>

            <!-- /.row -->
          </div>
      </section>
      <!-- /.content -->
    </div>
  </div>
  </div>
  <script src="../js/verificaIdade.js"></script>
  <script src="../js/consultaCep.js"></script>

  <?php include('../includes/footer.php'); ?>