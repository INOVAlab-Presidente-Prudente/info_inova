<?php 
    ob_start();
    include("../includes/header.php");
    include("../includes/permissoes.php");
?>
<body class="hold-transition sidebar-mini" onload="verificaIdade(dataNascimento); document.title='Admin Page | Consulta de Usuario'">
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
              <li class="breadcrumb-item active" ><?=$row['usu_nome']?></li>
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
                  if (isset($_GET['usuario_alterado']))
                      echo "<div class='alert alert-success' role='alert'>Usuário alterado com sucesso</div>";
                  if (isset($_GET['usuario_nao_alterado']))
                      echo "<div class='alert alert-warning' role='alert'>Não foi possível alterar este usuário. Dados incorretos.</div>";
                  if (isset($_GET['erro']))
                      echo "<div class='alert alert-info' role='alert'>Você nao tem permissão para alterar um usuário com esse perfil.</div>";
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
                    <div class="col-9">
                      <div class="row">
                        <div class="form-group col-12">
                          <label >Nome</label>
                          <input required <?=$alterar?> type="text" name="nome" class="form-control" <?="value='".$row['usu_nome']."'"?>>                        
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-4">
                            <label>CPF</label>
                            <input required <?=$alterar?> pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}" minlength="14" maxlength="14" id="cpf" type="text" name="cpf" class="form-control" <?="value='".$row['usu_cpf']."'"?>>
                        </div>
                        <div class="form-group col-4">
                            <label>RG</label>
                            <input required <?=$alterar?> type="text" pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9a-zA-Z]{1}" minlength="12" maxlength="12" id="rg" name="rg" class="form-control" <?="value='".$row['usu_rg']."'"?>>
                        </div>
                        <div class="form-group col-4">
                          <label>Data de Nascimento</label>
                          <input required <?=$alterar?> type="date" id="dataNascimento" onchange="verificaIdade(this)" name="dataNascimento" class="form-control" <?="value='".$row['usu_data_nascimento']."'"?>>
                          <input type="hidden" id="idade" name="idade" value="">
                        </div>
                      </div>
                    
                      <div class="row" id="responsavel" style="display: none;">
                        <div class="form-group col-6">
                            <label>Nome do Responsável</label>
                            <input <?=$alterar?> type="text"  id="nomeResponsavel" name="responsavel" class="form-control" <?="value='".$row['usu_responsavel']."'"?>>
                        </div>

                        <div class="form-group col-6">
                            <label>Telefone do Responsável</label>
                            <input <?=$alterar?> type="phone" id="telResponsavel" pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" name="telResponsavel" class="form-control" <?="value='".$row['usu_tel_responsavel']."'"?>>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-3">
                          <label>CEP</label>
                          <input required <?=$alterar?> pattern="[0-9]{5}-[0-9]{3}" minlength="9" maxlength="9" onpaste="consultaCEP(this.value)" onchange="consultaCEP(this.value)" type="text" id="cep" name="cep" class="form-control" <?="value='".$row['usu_cep']."'"?>>
                        </div>
                        <div class="form-group col-4">
                          <label>Município</label>
                          <input required <?=$alterar?> type="text" id="municipio" name="municipio" class="form-control" <?="value='".$row['usu_municipio']."'"?>>
                        </div>
                        <div class="form-group col-5">
                          <label>Bairro</label>
                          <input required <?=$alterar?> type="text" id="bairro" name="bairro" class="form-control" <?="value='".$row['usu_bairro']."'"?>>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-12">
                          <label>Endereço</label>
                          <input required <?=$alterar?> type="text" id="endereco" name="endereco" class="form-control" <?="value='".$row['usu_endereco']."'"?>>
                        </div>
                      </div>
                    </div>
                    <div class="col-3 md-4 mb-2">
                    <?php 
                      if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                          echo '<img id="imgUsuario" src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="img-fluid mx-auto" alt="User Image">';
                      else
                          echo '<img id="imgUsuario" src="../images/avatar-df.png" class="img-fluid img-thumbnail" alt="User Image">';
                    ?>
                        
                        <script>
                            
                        </script>
                        <section class="modal-camera" id="modal-camera">
                          <div class="modal-content">
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
                        <div class="input-group row justify-content-center m-2">
                          <div class="input-wrapper">
                            <input type="hidden" id="img64" name="img64"/>
                            <input class="btn btn-secondary text-weight" type="button" <?=$alterar?> onclick="abrirModal()" value="Tirar Foto"></input>
                            <input class="" type="file" name="uploadFoto" id="uploadFoto" <?=$alterar?> >
                            <label class="">Escolha Foto</label>
                          </div>
                        </div>
                        <script>
                          var fileInput1 = document.getElementById('uploadFoto');
                          fileInput1.onchange = function(e){
                            if (fileInput1.files && fileInput1.files[0]) {
                                  var reader = new FileReader();
                                  reader.onload = function(e) {
                                      $('#imgUsuario').attr('src', e.target.result);
                                  }
                                  reader.readAsDataURL(fileInput1.files[0]); // convert to base64 string
                            }
                          }
                        </script>
                    </div>
                  </div><!-- fim row 1 -->

                  <div class="row">
                    <div class="form-group col-8">
                      <label>Email</label>
                      <input required <?=$alterar?> type="email" name="email" class="form-control" <?="value='".$row['usu_email']."'"?>>
                    </div>
                    <div class="form-group col-4">
                      <label>Telefone(com DDD)</label>
                      <input required <?=$alterar?> type="phone" id="telefone" name="telefone" pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" minlength="13" maxlength="14" class="form-control" <?="value='".$row['usu_telefone']."'"?>>
                    </div>
                  </div><!-- fim row 2 -->

                  <div class="row">
                    <div class="form-group col-6">
                      <label>Área de Atuação</label>
                      <input required <?=$alterar?> type="text" name="areaAtuacao" class="form-control" <?="value='".$row['usu_area_atuacao']."'"?>>
                    </div>

                    <div class="form-group col-6">
                      <label>Área de Interesse</label>
                      <input required <?=$alterar?> type="text" name="areaInteresse" class="form-control" <?="value='".$row['usu_area_interesse']."'"?>>
                    </div>
                  </div><!-- fim row 3 -->
                  
                  <div class="row">
                    <div class="form-group col-7">
                      <label>Empresa:</label>
                      <select class="form-control" name="empresa" <?=$alterar?>><br>
                          <option>...</option>
                          <?php 
                              $sql = "SELECT * FROM empresa";
                              $query = mysqli_query($connect, $sql);
                              $res = mysqli_fetch_array($query);

                              while ($res != null) {
                                  if ($row['emp_id'] == $res['emp_id']){ 
                                      echo "<option selected value=".$res['emp_id'].">".$res['emp_razao_social']." </option>";}
                                  else{
                                      echo "<option value='".$res['emp_id']."'>". $res['emp_razao_social'] ."</option>";}
                                  $res = mysqli_fetch_array($query);
                              }
                          ?>
                      </select>
                    </div>
                    <div class="form-group col-1 my-auto mx-auto ">
                      <div class="custom-control custom-checkbox">
                        <input <?=$alterar?> class="custom-control-input required" type="checkbox" name="socio" id="socio" <?=$alterar?> <?=$row['usu_socio'] ? "checked" : '';?>>
                        <label class="custom-control-label mt-3" for="socio">Socio</label><br>               
                      </div>
                    </div>
                    <div class="form-group col-4">
                      <label>Perfil de Usuário</label>
                      <select <?=$alterar?> name="perfil" class="form-control">
                        <?php
                            $sql = "SELECT * FROM perfil_usuario";
                            $query = mysqli_query($connect, $sql);
                            $res = mysqli_fetch_array($query);    

                            while ($res != null) {
                                if ($row['pu_id'] == $res['pu_id']){ 
                                    echo "<option selected value=".$res['pu_id'].">".ucwords($res['pu_descricao'])." </option>";
                                }else{
                                    // echo "<option value='".$res['pu_id']."'>". $res['pu_descricao'] ."</option>";
                                    if (isset($_SESSION['admin']))
                                        echo "<option value='".$res['pu_id']."'>". ucwords($res['pu_descricao']) ."</option>";
                                    else if (isset($_SESSION['coworking'])) {
                                        if ($res['pu_descricao'] != "administrador" && $res['pu_descricao'] != "financeiro" && $res['pu_descricao'] != "coworking" && $res['pu_descricao'] != "evento")
                                            echo "<option value='".$res['pu_id']."'>". ucwords($res['pu_descricao']) ."</option>";
                                    }
                                }
                              $res = mysqli_fetch_array($query);
                            }
                        ?>
                      </select>
                    </div>
                  </div><!-- fim row 4 -->
                </div>

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
                                echo "<div class='col'> <button type='submit' name='alterar' class='btn btn-warning w-100'>Alterar</button> </div>";
                                echo "<div id='btn-excluir' name='excluir' class='col btn btn-danger w-100'> Excluir</div>";  
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
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
        </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  
  <div id="modal-excluir">
    <div class="modal-content">
        <h4>Excluir Usuário</h4>
        <p>Deseja excluir o usuário <?=$row['usu_nome']?> cpf <?=$row['usu_cpf']?>?</p>
        <div class="d-flex justify-content-center">
          <button onclick="excluirUsuario('<?=$row['usu_cpf']?>')" class='btn btn-danger'>Sim</button>
          <button id="btn-nao" class='btn btn-light'>Não</button>
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
        window.location.href="../admin/ExcluiUsuario.php?cpf="+cpf;
    }
  </script>
  <script src="../js/verificaIdade.js"></script>
  <script src="../js/consultaCep.js"></script>
  <!-- SweetAlert2 -->
  <script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="../../plugins/toastr/toastr.min.js"></script>
<?php include('../includes/footer.php'); ?>