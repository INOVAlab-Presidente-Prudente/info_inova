<?php 
    ob_start();
    include("../includes/header.php");
    include("../includes/primeirologin.php");
    include("../includes/permissoes.php");
?>
<body class="hold-transition sidebar-mini" onload="verificaIdade(dataNascimento); document.title=' Consulta de Usuario'">
  <?php
        include("../includes/navbar.php");
        include("../includes/sidebar.php");

        require_once("../admin/DB.php");
        $sql = "SELECT * FROM usuario WHERE usu_cpf = '".$_GET['cpf']."'";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($query);
    ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consulta de Usuário</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
              <li class="breadcrumb-item "><a href="/pages/consultarUsuario.php">Consulta de Usuário</a></li>
              <li class="breadcrumb-item active"><?=$row['usu_nome']?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Fazer o preenchimento automático dos campos via PHP2 -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">

              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" method="post" enctype="multipart/form-data">
                <?php
                  if (isset($_GET['usuario_alterado'])){
                      echo "<div class='alert alert-success alert-dismissible'>
                      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                      <h5><i class='fas fa-check'></i>&nbspUsuário(a) Alterado(a)!</h5>
                          <p>Usuário(a) foi alterado(a) com sucesso!.</p>
                      </div>";
                  }
                  if (isset($_GET['usuario_nao_alterado'])){
                      echo "<div class='alert alert-warning alert-dismissible'>
                              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                              <h5><i class='fas fa-exclamation-triangle'></i>&nbspDados Incorretos!</h5>
                              <p>Não foi possível alterar este(a) usuário(a).</p>
                            </div>";
                  }if (isset($_GET['erro'])){
                      echo "<div class='alert alert-warning alert-dismissible'>
                              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                              <h5><i class='fas fa-exclamation-triangle'></i>&nbspPermissão Negada!</h5>
                              <p>Você nao tem permissão para alterar um(a) usuário(a) com esse perfil.</p>
                            </div>";
                  
                    }
                  if (!isset($_GET['alterar'])){
                      $alterar = 'disabled';
                  }
                  else if (isset($_GET['alterar']) && ($row['pu_id'] != '1' && $row['pu_id'] != '2' || isset($_SESSION['admin']) || (isset($_SESSION['coworking']) && $row['usu_cpf'] == $_SESSION['cpf']))){
                      $alterar = "enabled";
                  }else{ 
                      $alterar = 'disabled';
                  }
                  if ($row != null) {
                ?>
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-3 col-md-4 order-lg-1 mx-auto">
                      <?php 
                          if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                              echo '<img id="imgUsuario" src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="img-fluid mx-auto" alt="User Image">';
                          else
                              echo '<img id="imgUsuario" src="../images/avatar-df.png" class="img-fluid img-thumbnail" alt="User Image">';
                        ?>
                      <section class="modal-camera" id="modal-camera">
                        <div class="modal-content">
                          <video id="video" autoplay></video>
                          <button type="button" onclick="tirarFoto()">
                            <i class="fas fa-camera-retro"></i>
                          </button>
                          <script>
                            const modalCamera = document.getElementById("modal-camera");

                            function abrirModal() {
                              modalCamera.style.display = "block";
                              startVideoFromCamera();
                            }
                            window.onclick = (e) => {
                              if (e.target === modalCamera)
                                modalCamera.style.display = 'none';
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
                              modalCamera.style.display = 'none';
                            }
                            //window.addEventListener("DOMContentLoaded", startVideoFromCamera())
                          </script>
                        </div>
                      </section>
                      <div class="input-group">
                        <div class="input-wrapper mx-auto">
                          <!-- <div class="container my-auto mx-auto"> -->
                          <input type="hidden" id="img64" name="img64" />
                          <button <?=$alterar?> class="btn btn-secondary btn-md" type="button"
                            onclick="abrirModal()">Tirar
                            Foto</button>
                          <input type="file" name="uploadFoto" id="uploadFoto">
                          <button <?=$alterar?> class="btn btn-secondary btn-md" type="button"
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
                          <input required <?=$alterar?> type="text" name="nome" class="form-control" placeholder=""
                            <?="value='".$row['usu_nome']."'"?>>
                        </div>
                      </div>

                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>CPF</label>
                              <input required <?=$alterar?> pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14"
                                maxlength="14" type="text" id="cpf" name="cpf" class="form-control"
                                placeholder="xxx.xxx.xxx-xx" <?="value='".$row['usu_cpf']."'"?>>
                            </div>
                          </div>

                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>RG</label>
                              <input required <?=$alterar?> pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9a-zA-Z]{1}"
                                minlength="12" maxlength="12" type="text" id="rg" name="rg" class="form-control"
                                placeholder="xx.xxx.xxx-x" <?="value='".$row['usu_rg']."'"?>>
                            </div>
                          </div>

                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>Data de Nascimento</label>
                              <input required <?=$alterar?> type="date" onchange="verificaIdade(this)" id="dataNascimento"
                                name="dataNascimento" class="form-control"
                                <?="value='".$row['usu_data_nascimento']."'"?>>
                              <input type="hidden" name="idade" id="idade" value="" />
                            </div>
                          </div>
                        </div>
                      
                        <div id="responsavel" style="display: none;">
                          <div class="row">
                            <div class="col-lg-7">
                              <div class="form-group">
                                <label>Nome do Responsável</label>
                                <input <?=$alterar?> type="text" id="nomeResponsavel" name="responsavel" class="form-control"
                                  <?="value='".$row['usu_responsavel']."'"?>>
                              </div>
                            </div>

                            <div class="col-lg-5">
                              <div class="form-group">
                                <label>Telefone do Responsável</label>
                                <input <?=$alterar?> pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14"
                                  type="phone" id="telResponsavel" name="telResponsavel" class="form-control"
                                  placeholder="(xx)xxxxx-xxxx" <?="value='".$row['usu_tel_responsavel']."'"?>>
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
                              <input required <?=$alterar?> pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9"
                                onpaste="consultaCEP(this.value)" oninput="consultaCEP(this.value)" type="text" id="cep"
                                name="cep" class="form-control" placeholder="xxxxx-xxx"
                                <?="value='".$row['usu_cep']."'"?>>
                            </div>
                          </div>
                          <div class="col-lg-4">
                            <div class="form-group">
                              <label>Município</label>
                              <input required <?=$alterar?> type="text" id="municipio" name="municipio"
                                class="form-control" placeholder="Municipio" <?="value='".$row['usu_municipio']."'"?>>
                            </div>
                          </div>

                          <div class="col-lg-5">
                            <div class="form-group ">
                              <label>Bairro</label>
                              <input required <?=$alterar?> type="text" id="bairro" name="bairro" class="form-control"
                                placeholder="Bairro" <?="value='".$row['usu_bairro']."'"?>>
                            </div>
                          </div>

                          <div class="col-lg-12">
                            <div class="form-group">
                              <label>Endereço</label>
                              <input required <?=$alterar?> type="text" id="endereco" name="endereco"
                                class="form-control" placeholder="" <?="value='".$row['usu_endereco']."'"?>>
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
                          <input required <?=$alterar?> type="email" name="email" class="form-control"
                            placeholder="example@email.com" <?="value='".$row['usu_email']."'"?>>
                        </div>
                      </div>
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>Telefone(com DDD)</label>
                          <input required <?=$alterar?> pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}"
                            minlength="13" maxlength="14" type="phone" id="telefone" name="telefone"
                            class="form-control" placeholder="(xx)xxxxx-xxxx" <?="value='".$row['usu_telefone']."'"?>>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Área de Atuação</label>
                          <input required <?=$alterar?> type="text" name="areaAtuacao" class="form-control"
                            placeholder="" <?="value='".$row['usu_area_atuacao']."'"?>>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Área de Interesse</label>
                          <input required <?=$alterar?> type="text" name="areaInteresse" class="form-control"
                            placeholder="" <?="value='".$row['usu_area_interesse']."'"?>>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-lg-7">
                        <div class="form-group ">
                          <label>Empresa</label>
                          <select required <?=$alterar?> name="empresa" class="form-control ">
                            <option>...</option>
                            <?php 
                                    require_once("../admin/DB.php");
                                    $sql = "SELECT * FROM empresa ORDER BY emp_razao_social";
                                    $query = mysqli_query($connect, $sql);
                                    $res = mysqli_fetch_array($query);

                                    while ($res != null) {
                                        $nome  = (empty($res['emp_nome_fantasia']))? $res['emp_razao_social'] : $res['emp_nome_fantasia'];
                                        if ($row['emp_id'] == $res['emp_id'])
                                          echo "<option selected value='".$res['emp_id']."'>". $nome ."</option>";
                                        else
                                          echo "<option value='".$res['emp_id']."'>". $nome ."</option>";
                                        $res = mysqli_fetch_array($query);
                                    }
                                ?>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-1 d-flex">
                        <div class="form-group my-auto">
                          <div class="custom-control custom-checkbox">
                            <input <?=$alterar?> class="custom-control-input required" type="checkbox" name="socio" id="socio"
                              <?=$row['usu_socio'] ? "checked" : '';?>>
                            <label class="custom-control-label mt-3" for="socio">Socio</label><br>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label>Perfil de Usuário</label>
                          <select required <?=$alterar?> name="perfil" class="form-control">
                            <?php
                                $sql = "SELECT * FROM perfil_usuario";
                                $query = mysqli_query($connect, $sql);
                                $res2 = mysqli_fetch_array($query);    

                                while ($res2 != null) {
                                    if ($res2['pu_id'] == $row['pu_id'])
                                        echo "<option selected value='".$res2['pu_id']."'>". ucwords($res2['pu_descricao']) ."</option>";
                                    else if (isset($_SESSION['admin']))
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
                <div class="card-footer form-group">
                  <div class="row">
                    <?php 
                        if (isset($_GET['alterar']) && ($row['pu_id'] != '1' && $row['pu_id'] != '2' || isset($_SESSION['admin']) || (isset($_SESSION['coworking']) && $row['usu_cpf'] == $_SESSION['cpf']))) {
                            echo "<button class='btn btn-success' name='confirmar'>Confirmar</button>";
                            echo "<button class='btn btn-light' name='cancelar'>Cancelar</button>";
                            if (isset($_POST['confirmar'])) {
                              require_once("../admin/AlteraUsuario.php");
                            }
                            if (isset($_POST['cancelar'])) {
                                header("location: ?cpf=".$row['usu_cpf']."");
                            }
                        } 
                        else if (isset($_GET['excluir']) && ($row['pu_id'] != '1' && $row['pu_id'] != '2' || isset($_SESSION['admin']) || (isset($_SESSION['coworking']) && $row['usu_cpf'] == $_SESSION['cpf']))) {
                            echo "<button class='btn btn-danger' name='sim'>Sim</button>";
                            echo "<button class='btn btn-light' name='nao'>Não</button>";
                            if (isset($_POST['sim'])) {
                                require_once("../admin/ExcluiUsuario.php");
                            }
                            if (isset($_POST['nao'])) {
                                header("location: ?cpf=".$row['usu_cpf']."");
                            }
                        }
                        else {
                            if ($row['pu_id'] != '1' && $row['pu_id'] != '2' || isset($_SESSION['admin']) || (isset($_SESSION['coworking']) && $row['usu_cpf'] == $_SESSION['cpf'])) {
                                echo "<div class='col'><button type='submit' name='alterar' class='btn btn-warning w-100'>Alterar</button></div>";
                                echo "<div class='col'><button id='btn-excluir' type='button' name='excluir' class='col btn btn-danger w-100'> Excluir</button></div>";  
                                echo "<div class='col'><button type='button' class='btn btn-info w-100' onclick='window.location.href = \"ocorrencias.php?usu_id=".$row['usu_id']."\"'>Ocorrências</button></div>"  ;
                            }
                            if (isset($_POST['alterar'])) {
                                header("location: ?cpf=".$row['usu_cpf']."&alterar=enabled");
                                
                            }
                        }
                    ?>
                  </div>
                </div>
                <?php
                
                    }else {
                        header("location: consultarUsuario.php");
                    }
                ?>
              </form>
            </div>
            <!-- /.row -->
          </div>
    </section>
    <!-- /.content -->
  </div>
  </div>
  </div>

  <div id="modal-excluir">
    <div class="modal-content">
      <div class="container-fluid">
        <div class="row align-itens-center justify-content-center">
          <div class="text-center">
            <h4>Excluir Usuário</h4>
            <p>Deseja excluir o usuário <?=$row['usu_nome']?> cpf <?=$row['usu_cpf']?>?</p>
          </div>
          <div class="d-flex">
            <button onclick="excluirUsuario('<?=$row['usu_cpf']?>')" class='btn btn-danger'>Sim</button>
            <div class="col-1"></div>
            <button id="btn-nao" class='btn btn-light'>Não</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const modal = document.getElementById("modal-excluir");
    const btnExcluir = document.getElementById("btn-excluir");
    const btnNao = document.getElementById("btn-nao");

    btnExcluir.onclick = () => {
      modal.style.display = "block";
    }
    window.onclick = (e) => {
      if (e.target === modal || e.target === btnNao)
        modal.style.display = 'none';
    }

    function excluirUsuario(cpf) {
      window.location.href = "../admin/ExcluiUsuario.php?cpf=" + cpf;
    }
  </script>
  <script src="../js/verificaIdade.js"></script>
  <script src="../js/consultaCep.js"></script>
  <!-- SweetAlert2 -->
  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Toastr -->
  <script src="../../plugins/toastr/toastr.min.js"></script>
  <?php include('../includes/footer.php'); ?>