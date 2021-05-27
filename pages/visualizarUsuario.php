<?php
  $titulo = "Vizualizar Usuário";
  include ('../includes/header.php');
  include ('../includes/permissoes.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  require_once("../admin/DB.php");
  $sql = "	SELECT u.*, pu_descricao, emp_nome_fantasia, emp_razao_social
            FROM usuario u 
            LEFT JOIN empresa emp ON emp.emp_id = u.emp_id
            LEFT JOIN perfil_usuario pu ON pu.pu_id = u.pu_id
            WHERE u.usu_cpf = '".$_GET['cpf']."' "; 
  $query = mysqli_query($connect, $sql);
  if($query)
    $row = mysqli_fetch_assoc($query);
  else
    header("location: /pages/adminPage.php");
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Visualizar Usuário</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="adminPage.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarUsuario.php">Usuários</a></li>
              <li class="breadcrumb-item">Visualizar</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <?php 
              if (isset($_GET['usuario_alterado'])){
                echo "<div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-check'></i>&nbspUsuário Alterado!</h5>
                    <p>Usuário foi alterado com sucesso!</p>
                </div>";
              }
              if (isset($_GET['usuario_nao_alterado'])){
                  echo "<div class='alert alert-warning alert-dismissible'>
                          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                          <h5><i class='fas fa-exclamation-triangle'></i>&nbspDados Incorretos!</h5>
                          <p>Não foi possível alterar este usuário.</p>
                        </div>";
              }
              if (isset($_GET['erro'])){
                echo "<div class='alert alert-warning alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-exclamation-triangle'></i>&nbspPermissão Negada!</h5>
                        <p>Você nao tem permissão para alterar um usuário com esse perfil.</p>
                      </div>";
              }
            ?>
            <div class="invoice p-3 mb-3">
              <div class="row">
                <div class="col-12 mb-4">
                    <?php 
                        if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                            echo '<img id="imgUsuario" src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="profile-user-img img-fluid img-circle border-2 border-default" style="height:100px;" alt="User Image">';
                        else
                            echo '<img id="imgUsuario" src="../images/avatar-df.png" class="profile-user-img img-fluid img-circle border-2 border-default" alt="User Image">';
                    ?>
                  <h2><?=htmlspecialchars($row['usu_nome'])?></h2>
                  <a href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>&alterar=true" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Usuário
                  </a>
                </div>
              </div>
              <div class="row invoice-info mb-4">
                <div class="col-md-4 invoice-col">
                  <b>Email: </b><?=htmlspecialchars($row['usu_email'])?><br/>
                  <b>Data de nascimento: </b><?=htmlspecialchars($row['usu_data_nascimento'])?><br/>
                  <b>RG: </b><?=htmlspecialchars($row['usu_rg'])?><br/>
                  <b>CPF: </b><?=htmlspecialchars($row['usu_cpf'])?><br/>
                  <b>Telefone: </b><?=htmlspecialchars($row['usu_telefone'])?><br/>
                  <!-- Fazer Verificação para ver se tem responsável -->
                  <?php           
                    if($row['usu_responsavel'] != null && $row['usu_tel_responsavel'] != null){
                        echo "<b>Nome do Responsável: </b>".htmlspecialchars($row['usu_responsavel'])."<br/>";
                        echo "<b>Telefone do Responsável: </b>".htmlspecialchars($row['usu_tel_responsavel'])."<br/>";
                    }
                  ?>
                </div>
                <div class="col-md-4 invoice-col">
                  <b>Área de Atuação: </b><?=htmlspecialchars($row['usu_area_atuacao'])?><br/>
                  <b>Área de Interesse: </b><?=htmlspecialchars($row['usu_area_interesse'])?><br/>
                  <?php 
                    if ($row['emp_id'] != null):
                      $empresa = $row['emp_nome_fantasia'] ? $row['emp_nome_fantasia'] : $row['emp_razao_social'];
                  ?>
                    <b>Empresa: </b><?=htmlspecialchars($empresa)?><br/>
                    <b>Socio: </b><?=$row['usu_socio'] ? "Sim" : "Não";?><br/>                  
                  <?php endif;?>
                  <b>Perfil de Usuário: </b><?=htmlspecialchars(ucwords($row['pu_descricao']))?><br/>
                </div>
                <div class="col-md-4 invoice-col">
                  <address>
                    <b>CEP: </b><?=htmlspecialchars($row['usu_cep'])?><br/>
                    <b>Endereço: </b><?=htmlspecialchars($row['usu_endereco'])?><br/>
                    <b>Complemento: </b><?=htmlspecialchars($row['usu_complemento'])?><br/>
                    <b>Bairro: </b><?=htmlspecialchars($row['usu_bairro'])?><br/>                
                    <b>Cidade: </b><?=htmlspecialchars($row['usu_municipio'])?><br/>
                    <b>Estado: </b><?=htmlspecialchars($row['usu_estado'])?><br/>
                  </address>
                </div>
              </div>
            </div>
          </div>
        </div>        
      </div>
    </section>
</div>
<?php
  include ('../includes/footer.php');
?>