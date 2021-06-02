<?php
  $titulo = "Visualizar Empresa";
  include ('../includes/header.php');
  include ('../includes/primeirologin.php');
  include ('../includes/navbar.php');
  include ('../includes/sidebar.php');

    if(isset($_GET['cnpj'])){

        require_once("../admin/DB.php");
        $sql = "SELECT * FROM empresa WHERE emp_cnpj = '".$_GET['cnpj']."'";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($query);
        
        if($row == NULL)
            header("location: consultarEmpresa.php");
    }
    else
        header("location: consultarEmpresa.php");
?> 
<div class="content-wrapper">
    <section class="content-header">
      <section class="container-fluid">
        <?php 
        if (isset($_GET['empresa_alterada'])){
            echo "<div class='alert alert-success alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-check'></i>&nbspEmpresa Alterada!</h5>
                        <p>A empresa foi alterada com sucesso!</p>
                  </div>";
        }
        ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Visualizar Empresa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="checkin.php">Início</a></li>
              <li class="breadcrumb-item"><a href="consultarEmpresa.php">Empresas</a></li>
              <li class="breadcrumb-item">Visualizar</li>
            </ol>
          </div>
        </div>
      </section>
    </section>
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
                  <h2><?=ucwords($row['emp_nome_fantasia'] == null ? htmlspecialchars($row['emp_razao_social']) : htmlspecialchars($row['emp_nome_fantasia'])) ?></h2>
                  <a href="consultarEmpresaEdit.php?cnpj=<?=$_GET['cnpj']?>&alterar=enabled" class="btn btn-warning btn-sm center">
                    <i class="fas fa-edit"></i>&nbsp;
                    Alterar Empresa
                  </a>
                </div>
              </div>
              <div class="row invoice-info mb-2">
                <div class="col-md-6 invoice-col">
                  <b>CNPJ:</b>&nbsp;<?=htmlspecialchars($row['emp_cnpj'])?><br>
                  <b>Telefone:</b>&nbsp;<?=htmlspecialchars($row['emp_telefone'])?><br>
                  <b>Email:</b>&nbsp;<?=htmlspecialchars($row['emp_email'])?><br>
                  <b>Razão Social:</b>&nbsp;<?=htmlspecialchars(strtoupper($row['emp_razao_social']))?><br>
                  <b>Nome Fantasia:</b>&nbsp;<?=htmlspecialchars($row['emp_nome_fantasia'])?><br>
                  <b>Atividade Principal:</b>&nbsp;<?=htmlspecialchars($row['emp_area_atuacao'])?><br>  
                </div>
                <div class="col-md-6 invoice-col">
                  <?php
                    if(isset($row['mod_id'])){
                      require_once("../admin/DB.php");
                      $sql = "SELECT * FROM modalidade WHERE mod_id = '".$row['mod_id']."'";
                      $query2 = mysqli_query($connect, $sql);
                      $row2 = mysqli_fetch_assoc($query2);
                      
                      if($row2 == NULL){
                        echo "<b>Modalide:</b>&nbsp;Modalidade não existente!<br/>";}
                      else{
                        echo "<b>Modalide:</b>&nbsp;".$row2['mod_nome']."<br/>";
                      }
                    }
                    else
                      echo "<b>Modalide:</b>&nbsp;Empresa não possui modalidade contratada.<br/>";
                        
                  ?>
                  
                  <b>Município:</b>&nbsp;<?=htmlspecialchars($row['emp_municipio'])?> - <?=htmlspecialchars( $row['emp_estado'])?><br/>
                  <b>CEP:</b>&nbsp;<?=htmlspecialchars($row['emp_cep'])?><br/>
                  <b>Endereço:</b>&nbsp;<?=htmlspecialchars($row['emp_endereco'])?><br>
                  <b>Número:</b>&nbsp;<?=htmlspecialchars($row['emp_numero'])?><br>
                  <b>Complemento:</b>&nbsp;<?=htmlspecialchars( $row['emp_complemento'])?><br/>
                  <b>Bairro:</b>&nbsp;<?=htmlspecialchars($row['emp_bairro'])?><br/>
                </div>
              </div>
            </div>
          </div>
        </div>     
      </div>
    </section>
  </section>
</div>
<?php
  
  include ('../includes/footer.php');
?>