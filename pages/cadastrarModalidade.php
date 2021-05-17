<?php 
    include("../includes/header.php");
    include("../includes/primeirologin.php");
    if (!isset($_SESSION['admin']) && !isset($_SESSION['financeiro']))
        header("location: ../");
?>
<body class="hold-transition sidebar-mini" onload="document.title='Cadastrar Modalidade'">
    <?php include("../includes/sidebar.php") ?>
    <?php include("../includes/navbar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Cadastro de Modalidades</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                                <li class="breadcrumb-item active">Cadastro de modalidade</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <?php 
                        if(isset($_POST['cadastrar']))
                            require_once('../admin/CadastroModalidade.php');
                    ?>
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <form id="quickForm" method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input required type="text" name="nome" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Descricao</label>
                                        <input required type="text" name="descricao" class="form-control">
                                    </div> 
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Valor Mensal</label>
                                                <input required type="text" pattern="[0-9\.]+" name="valorMensal" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Valor Anual</label>
                                                <input required type="text" pattern="[0-9\.]+" name="valorAnual" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Edital</label>
                                        <input required type="text" name="edital" class="form-control">
                                    </div> 
                                    <button class="btn btn-primary" name="cadastrar">Cadastrar</button>
                                    
                                </div><!-- /.card-body -->
                            </form>
                        </div><!-- /.card-primary -->
                    </div><!-- /.col-md-12 -->
                </div> <!-- /.container-fluid -->       
            </section>
        </div>
    </div>
    <?php include("../includes/footer.php") ?>