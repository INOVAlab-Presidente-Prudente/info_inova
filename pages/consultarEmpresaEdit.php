<?php 
    ob_start();
    include("../includes/header.php");
?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Consultar Empresa'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
    <?php 
        require_once("../admin/DB.php");
        $sql = "SELECT * FROM empresa WHERE emp_cnpj = '".$_GET['cnpj']."'";
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($query);
        
        if (!isset($_GET['alterar']))
            $alterar = 'disabled';
        else
            $alterar = "type='text'";
        
    if($row!=NULL){            
    ?>
      <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Consultar de Empresa</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
              <li class="breadcrumb-item "><a href="/pages/consultarEmpresa.php">Consulta de Empresa</a></li>
              <li class="breadcrumb-item active"><?= $row['emp_razao_social'] ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form id="quickForm" action="" method="post">
                            <?php 
                                if (isset($_GET['empresa_alterada']))
                                    echo "<div class='alert alert-success' role='alert'>Empresa foi alterada</div>";
                                if (isset($_GET['empresa_nao_alterada']))
                                    echo "<div class='alert alert-warning' role='alert'>Não foi possível alterar esta empresa. Dados incorretos.</div>";
                            ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Razão social</label>
                                    <input <?=$alterar." value='".$row['emp_razao_social']."'"?> name="razaoSocial" class="form-control">
                                </div>  
                                <div class="form-group">
                                    <label>CNPJ</label>
                                    <input <?=$alterar." value='".$row['emp_cnpj']."'"?> pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}" name="cnpj" class="form-control">
                                </div>    
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input <?=$alterar." value='".$row['emp_telefone']."'"?> pattern="\([1-9]{2}\)(?:[2-8]|9[1-9])[0-9]{3}-[0-9]{4}" name="telefone" class="form-control">
                                </div>    
                                <div class="form-group">
                                    <label>Ramo de atuação</label>
                                    <input <?=$alterar." value='".$row['emp_area_atuacao']."'"?> name="areaAtuacao" class="form-control">
                                </div>  
                                
                                <label>Sócios:</label>
                                <?php 
                                    $sql = "SELECT u.usu_nome AS nome FROM usuario u, empresa e 
                                                WHERE u.emp_id = e.emp_id AND u.usu_socio = 1 AND emp_cnpj = '".$_GET['cnpj']."'";
                                    $query = mysqli_query($connect, $sql);
                                    $row2 = mysqli_fetch_assoc($query);

                                    while($row2!=null){
                                        echo "<div class='col'>".$row2['nome']."</div>";
                                        $row2 = mysqli_fetch_assoc($query);
                                    }
                                ?>
                            </div>
                            <div class="card-footer form-group"> 
                            <div class="row">
                            <?php 
                                if (isset($_GET['alterar'])) {
                                    echo "<button class='btn btn-success' name='confirmar'>Confirmar</button>";
                                    echo "<button class='btn btn-light' name='cancelar'>Cancelar</button>";
                                    if (isset($_POST['confirmar'])) {
                                        require_once("../admin/AlteraEmpresa.php");
                                    }
                                    if (isset($_POST['cancelar']))
                                        header("location: ?cnpj=".$row['emp_cnpj']."");
                                } 
                                else if (isset($_GET['excluir'])) {
                                    echo "<button class='btn btn-danger' name='sim'>Sim</button>";
                                    echo "<button class='btn btn-light' name='nao'>Nao</button>";
                                    if (isset($_POST['sim'])) {
                                        require_once("../admin/ExcluiEmpresa.php");
                                    }
                                    if (isset($_POST['nao']))
                                        header("location: ?cnpj=".$row['emp_cnpj']."");
                                    
                                }
                                else {
                                    echo "<div class='col'> <button name='alterar' class='btn btn-warning w-100'>Alterar</button> </div>";
                                    echo "<div id='btn-excluir' name='excluir' class='col btn btn-danger w-100'> Excluir</div>";
                                    if (isset($_POST['alterar'])) {
                                        header("location: ?cnpj=".$row['emp_cnpj']."&alterar=enabled");
                                    }
                                    
                                }
                            ?>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    <div id="modal-excluir">
        <div class="modal-content">
            <h4>Excluir Empresa</h4>
            <p>Deseja excluir a empresa <?=$row['emp_razao_social']?> cnpj <?=$row['emp_cnpj']?>?</p>
            <div class="d-flex justify-content-center">
            <button onclick="excluirUsuario('<?=$row['emp_cnpj']?>')" class='btn btn-danger'>Sim</button>
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
        function excluirUsuario(cnpj) {
            window.location.href="../admin/ExcluiEmpresa.php?cnpj="+cnpj;
        }
    </script>
    <?php include('../includes/footer.php');
}
else
    header("location: /consultarEmpresa.php");
?>
