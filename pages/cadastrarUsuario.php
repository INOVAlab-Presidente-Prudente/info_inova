<?php include('../includes/header.php'); ?>

<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Cadastrar Usuario'">

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
            <!-- left column -->
            <div class="col-md-12">
              <!-- jquery validation -->
              <div class="card card-primary">
                
                <!-- /.card-header -->
                <!-- form start -->
                <form action="" id="quickForm" method='post'>
                <div class="card-header">
                  <?php 
                    if (isset($_POST['cadastrar'])) {
                        require_once("../admin/CadastroUsuario.php");
                    } 
                  ?>
                </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="row">
                          <div class="form-group col-12">
                            <label >Nome</label>
                            <input required type="text" name="nome" class="form-control" placeholder="">
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-4">
                              <label>CPF</label>
                              <input required pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14"type="text" id="cpf" name="cpf" class="form-control" placeholder="xxx.xxx.xxx-xx">
                          </div>
                          <div class="form-group col-4">
                              <label>RG</label>
                              <input required pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9a-zA-Z]{1}" minlength="12" maxlength="12" type="text" id="rg" name="rg" class="form-control" placeholder="xx.xxx.xxx-x">
                          </div>
                          <div class="form-group col-4">
                            <label>Data de Nascimento</label>
                            <input required type="date" onchange="verificaIdade(dtNasc)" id="dtNasc" name="dataNascimento" class="form-control" >
                            <input type="hidden" name="idade" id="idade" value=""/>
                          </div>
                        </div>

                        <div class="row" id="responsavel" style="display: none;">
                          <div class="form-group col-6">
                              <label>Nome do Responsável</label>
                              <input type="text" id="nomeResponsavel" name="responsavel" class="form-control" >
                          </div>

                          <div class="form-group col-6">
                              <label>Telefone do Responsável</label>
                              <input pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" type="phone" id="telResponsavel" name="telResponsavel" class="form-control" placeholder="(xx)xxxxx-xxxx">
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-3">
                              <label>CEP</label>
                              <input required pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9" onpaste="consultaCEP(this.value)" oninput="consultaCEP(this.value)" type="text" id="cep" name="cep" class="form-control" placeholder="xxxxx-xxx">
                          </div>
                          <div class="form-group col-4">
                            <label>Município</label>
                            <input required type="text" id="municipio" name="municipio" class="form-control" placeholder="Municipio">
                          </div>
                          <div class="form-group col-5">
                              <label>Bairro</label>
                              <input required type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro">
                          </div>
                        </div>

                        <div class="row">
                          <div class="form-group col-12">
                            <label>Endereço</label>
                            <input required type="text" id="endereco" name="endereco" class="form-control" placeholder="">
                          </div>
                        </div>
                          
                      </div>

                      <div class="col-3 md-4 mb-2">
                        <img src="../images/avatar-df.png" class="img-fluid img-thumbnail" id="imgUsuario" alt="">
                        <input type="hidden" id="img64" name="img64"/>
                        <input type="button" onclick="abrirModal()" value="Tirar Foto"></input>
                        <section class="modal-camera" id="modal-camera">
                          <div class="modal-content">
                            <video id="video" autoplay></video>
                            <button type="button" onclick="tirarFoto()">
                              <i class="fas fa-camera-retro"></i>
                            </button>
                            <script>
                                const modal = document.getElementById("modal-camera");
                                function abrirModal(){
                                  modal.style.display = "block";
                                  startVideoFromCamera();
                                }
                                window.onclick = (e) => {
                                    if (e.target === modal)
                                      modal.style.display = 'none';
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
                                  modal.style.display = 'none';
                                }
                                //window.addEventListener("DOMContentLoaded", startVideoFromCamera())
                            </script>
                          </div>
                        </section>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-8">
                        <label>Email</label>
                        <input required type="email" name="email" class="form-control" placeholder="example@email.com">
                      </div>
                      <div class="form-group col-4">
                        <label>Telefone(com DDD)</label>
                        <input required pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" type="phone" id="telefone" name="telefone" class="form-control" placeholder="(xx)xxxxx-xxxx">
                      </div>
                      
                    </div>

                    <div class="row">
                      <div class="form-group col-6">
                        <label>Área de Atuação</label>
                        <input required type="text" name="areaAtuacao" class="form-control" placeholder="">
                      </div>

                      <div class="form-group col-6">
                        <label>Área de Interesse</label>
                        <input required type="text" name="areaInteresse" class="form-control" placeholder="">
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="form-group col-7">
                        <label>Empresa</label>
                        <select required name="empresa" class="form-control ">
                            <option>...</option>
                            <?php 
                                require_once("../admin/DB.php");
                                $sql = "SELECT * FROM empresa";
                                $query = mysqli_query($connect, $sql);
                                $res = mysqli_fetch_array($query);

                                while ($res != null) {
                                    echo "<option value='".$res['emp_id']."'>". $res['emp_razao_social'] ."</option>";
                                    $res = mysqli_fetch_array($query);
                                }
                            ?>
                        </select>
                      </div>    
                      <div class="form-group col-1 my-auto mx-auto ">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input required" type="checkbox" name="socio" id="socio">
                          <label class="custom-control-label mt-3" for="socio">Socio</label><br>               
                        </div>
                      </div>
                      <div class="form-group col-4">
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
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                  </div>
                </form>
              </div>
              
              <!-- /.card -->
              </div>
            <!--/.col (left) -->
            </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
  </div>
  <script src="../js/verificaIdade.js"></script>
  <script src="../js/consultaCep.js"></script>
 
  <?php include('../includes/footer.php'); ?>