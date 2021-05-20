<?php
  $titulo = "Alterar Empresa";
  include ('../includes/header.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

  require_once("../admin/DB.php");
  $sql = "SELECT u.*, pu_descricao, emp_nome_fantasia, emp_razao_social 
            FROM usuario u, perfil_usuario pu, empresa emp 
                WHERE usu_cpf = '".$_GET['cpf']."' AND pu.pu_id = u.pu_id AND emp.emp_id = u.emp_id";
  $query = mysqli_query($connect, $sql);
  if($query)
    $row = mysqli_fetch_assoc($query);
  else
    var_dump(mysqli_error($connect));

  
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
              <li class="breadcrumb-item"><a href="admin_page.php">Início</a></li>
              <li class="breadcrumb-item"><a href="usuarios.php">Usuários</a></li>
              <li class="breadcrumb-item">Visualizar</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-10 offset-md-1">
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="invoice p-3 mb-3">
              <div class="row">
                <div class="col-12 mb-4">
                    <?php 
                        if(in_array(hash("md5", $row['usu_cpf']).".png", scandir("../images/usuarios")))
                            echo '<img id="imgUsuario" src="../images/usuarios/'.hash("md5", $row['usu_cpf']).'.png" class="profile-user-img img-fluid img-circle border-2 border-default" style="height:100px;" alt="User Image">';
                        else
                            echo '<img id="imgUsuario" src="../images/avatar-df.png" class="profile-user-img img-fluid img-circle border-2 border-default" alt="User Image">';
                    ?>
                  <h2><?="".$row['usu_nome'].""?></h2>
                  <a href="consultarUsuarioEdit.php?cpf=<?=$row['usu_cpf']?>" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Usuário
                  </a>
                </div>
              </div>
              <div class="row invoice-info mb-4">
                <div class="col-md-4 invoice-col">
                  <b>Email:&nbsp;</b><?="".$row['usu_email'].""?><br/>
                  <b>Data de nascimento:&nbsp;</b><?="".$row['usu_data_nascimento'].""?><br/>
                  <b>RG:&nbsp;</b><?="".$row['usu_rg'].""?><br/>
                  <b>CPF:&nbsp;</b><?="".$row['usu_cpf'].""?><br/>
                  <b>Telefone:&nbsp;</b><?="".$row['usu_telefone'].""?><br/>
                  <!-- Fazer Verificação para ver se tem responsável -->
                  <?php           
                    if($row['usu_responsavel'] != null && $row['usu_tel_responsavel'] != null){
                        echo "<b>Nome do Responsável: </b>".$row['usu_responsavel']."<br/>";
                        echo "<b>Telefone do Responsável: </b>".$row['usu_tel_responsavel']."<br/>";
                    }
                  ?>
                </div>
                <div class="col-md-4 invoice-col">
                  <b>Área de Atuação:&nbsp;</b><?="".$row['usu_area_atuacao'].""?><br/>
                  <b>Área de Interesse:&nbsp;</b><?="".$row['usu_area_interesse'].""?><br/>
                  <b>Empresa:&nbsp;</b><?="".(empty($row['emp_nome_fantasia']))? $row['emp_razao_social'] : $row['emp_nome_fantasia'].""?><br/>
                  <b>Socio:&nbsp;</b><?=$row['usu_socio'] ? "Sim" : "Não";?><br/>                  
                  <b>Perfil de Usuário:&nbsp;</b><?="".$row['pu_descricao'].""?><br/>
                </div>
                <div class="col-md-4 invoice-col">
                  <address>
                    <b>CEP:&nbsp;</b><?="".$row['usu_cep'].""?><br/>
                    <b>Endereço:&nbsp;</b><?="".$row['usu_endereco'].""?><br/>
                    <b>Complemento:&nbsp;</b><?="".$row['usu_complemento'].""?><br/>
                    <b>Bairro:&nbsp;</b><?="".$row['usu_bairro'].""?><br/>                
                    <b>Cidade:&nbsp;</b><?="".$row['usu_municipio'].""?><br/>
                    <b>Estado:&nbsp;</b><?="".$row['usu_estado'].""?><br/>
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