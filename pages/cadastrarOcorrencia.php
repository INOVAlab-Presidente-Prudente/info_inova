<?php 
    $titulo = "Cadastrar Ocorrência";
    include("../includes/header.php");
    include("../includes/primeirologin.php");
    include('../includes/permissoes.php');
    if(!isset($_GET['usu_id']))
        header("location: ../");

    require_once("../admin/DB.php");
    $sql = "SELECT usu_nome, usu_cpf FROM usuario WHERE usu_id = '".$_GET['usu_id']."'";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    
?>
<body class="hold-transition sidebar-mini" onload="document.title=' Cadastrar Ocorrência'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Cadastrar Ocorrência</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                                <li class="breadcrumb-item "><a href="/pages/consultarUsuario.php">Usuários</a></li>
                                <li class="breadcrumb-item "><a href="/pages/ocorrencias.php?usu_id=<?=$_GET['usu_id']?>">Ocorrências</a></li>
                                <li class="breadcrumb-item active">Cadastrar</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <?php 
                            if(isset($_POST['cadastrar']))
                            require_once("../admin/CadastroOcorrencia.php"); 
                        ?>
                        <div class="card card-secondary">
                            <form action="" id="quickForm" method="post">
                                
                                <div class="card-header">
                                    <h3 class="card-title">Cadastrar nova ocorrência</h3>
                                </div>
                                <div class="card-body">
                                    <div class="lead">
                                        Nome: <strong><?=$row['usu_nome']?></strong>
                                        <br/>
                                        <small> CPF: <?=$row['usu_cpf']?></small>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="form-group col-md-6">
                                            <label>Data</label>
                                            <input type="date" id="dt" name="dt" class="form-control"/>
                                        </div>                                        
                                        <div class="form-group col-md-6">
                                            <label>Hora</label>
                                            <input type="time" id="hora" name="hora" class="form-control"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Descrição</label>
                                            <textarea id="descricao" name="descricao" class="form-control" placeholder="Insira a descrição do ocorrido aqui..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" name="cadastrar" class="btn btn-primary toastrDefaultSucess"><i class="fas fa-portrait"></i>&nbsp;&nbsp;Registrar Ocorrência</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

<?php include("../includes/footer.php") ?>