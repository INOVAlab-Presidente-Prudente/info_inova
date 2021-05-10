<?php 
    ob_start();
    include("../includes/header.php");
    if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");
?>
<body class="hold-transition sidebar-mini" onload="document.title='Consultar Modalidade'">
    <?php 
        include("../includes/sidebar.php");
        include("../includes/navbar.php"); 
    ?>
    <?php
        require_once('../admin/DB.php');
        $sql="SELECT * FROM modalidade WHERE mod_id =".$_GET['mod_id'];
        $query = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($query);
        
        if (!isset($_GET['alterar']))
            $alterar = 'disabled';
        else
            $alterar = "type='text'";
    if($row != null){
    ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Consulta de Modalidade</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="consultarModalidade.php">Consulta de Modalidade</a></li>
                                <li class="breadcrumb-item"></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <?php 
                                if(isset($_GET['modalidade-alterada'])){
                                    echo "<div class='alert alert-success alert-dismissible'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            <h5><i class='fas fa-check'></i>&nbspModalidade alterada!</h5>
                                                <p>A Modalidade com alterada com sucesso!.</p>
                                        </div>";
                                }
                                if(isset($_GET['erro-alterar'])){
                                    echo "<div class='alert alert-info alert-dismissible'>
                                            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                            <h5><i class='fas fa-info'></i>&nbspModalidade não alterada!</h5>
                                                <p>Não foi possível alterar a modalidade, tente novamente!.</p>
                                          </div>";
                                }
                            ?>
                            <form id="quickForm" method="post">
                                <div class="card-body">
                                    <input type="hidden" name="id" value="<?=$row['mod_id']?>">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input <?=$alterar." value='".$row['mod_nome']."'"?> required type="text" name="nome" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Descricao</label>
                                        <input <?=$alterar." value='".$row['mod_descricao']."'"?> required type="text" name="descricao" class="form-control">
                                    </div> 
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Valor Mensal</label>
                                                <input <?=$alterar." value='".$row['mod_valMensal']."'"?> pattern="[0-9\.]+" required type="text" name="valorMensal" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Valor Anual</label>
                                                <input <?=$alterar." value='".$row['mod_valAnual']."'"?> pattern="[0-9\.]+" required type="text" name="valorAnual" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Edital</label>
                                        <input <?=$alterar." value='".$row['mod_edital']."'"?> required type="text" name="edital" class="form-control">
                                    </div> 
                                    <div class="row">
                                <?php 
                                    if (isset($_GET['alterar'])) {
                                        echo "<button class='btn btn-success' name='confirmar'>Confirmar</button>";
                                        echo "<button class='btn btn-light' name='cancelar'>Cancelar</button>";
                                        if (isset($_POST['confirmar'])) {
                                            require_once("../admin/AlteraModalidade.php");
                                        }
                                        if (isset($_POST['cancelar']))
                                            header("location: ?mod_id=".$row['mod_id']."");
                                    } 
                                    else if (isset($_GET['excluir'])) {
                                        echo "<button class='btn btn-danger' name='sim'>Sim</button>";
                                        echo "<button class='btn btn-light' name='nao'>Nao</button>";
                                        if (isset($_POST['sim'])) {
                                            require_once("../admin/ExcluiModalide.php");
                                        }
                                        if (isset($_POST['nao']))
                                            header("location: ?mod_id=".$row['mod_id']."");
                                        
                                    }
                                    else {
                                        echo "<div class='col'> <button name='alterar' class='btn btn-warning w-100'>Alterar</button> </div>";
                                        echo "<div id='btn-excluir' name='excluir' class='col btn btn-danger w-100'> Excluir</div>";
                                        if (isset($_POST['alterar'])) {
                                            header("location: ?mod_id=".$row['mod_id']."&alterar=enabled");
                                        }
                                        
                                    }
                                ?>
                                </div>
                                </div><!-- /.card-body -->
                            </form>
                        </div><!-- /.card-primary -->
                    </div><!-- /.col-md-12 -->
                </div> <!-- /.container-fluid -->       
            </section>
        </div>
        
        <div id="modal-excluir">
            <div class="modal-content"> 
                <div class="container-fluid"> 
                    <div class="row align-itens-center justify-content-center">
                    <div class="text-center"> 
                        <h4>Excluir Modalidade</h4> 
                        <p>Deseja excluir a modalidade <?=$row['mod_nome']?>?</p>
                    </div>
                    <div class="d-flex">
                        <button onclick="excluirModalidade('<?=$row['mod_id']?>')" class='btn btn-danger'>Sim</button>
                        <div class="col-1"></div>
                        <button id="btn-nao" class='btn btn-light'>Não</button>
                    </div>
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
        function excluirModalidade(id) {
            window.location.href="../admin/ExcluiModalidade.php?mod_id="+id;
        }    
    </script>
<?php 
    
     include("../includes/footer.php"); 
     
    }
    else
        header("location: /pages/consultarModalidade.php");?>