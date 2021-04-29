<?php include("../includes/header.php");
    if(!isset($_GET['usu_id']))
        header("location: ../");

    require_once("../admin/DB.php");
    $sql = "SELECT usu_nome FROM usuario WHERE usu_id = '".$_GET['usu_id']."'";
    $query = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($query);
    
?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Cadastrar Ocorrência'">
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
                                <li class="breadcrumb-item "><a href="/pages/consultarUsuario.php">Consulta de Usuário</a></li>
                                <li class="breadcrumb-item active" >Cadastrar Ocorrência</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <form action="" id="quickForm" method="post">
                                    <div class="card-header">
                                        <h1 class="card-title">Cadastrar Ocorrência para <strong><?=$row['usu_nome']?></strong></h1>
                                        <!-- Inserir o require_once do backend -->
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Data</label>
                                            <input type="date" id="dt" name="dt" class="form-control"/>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Hora</label>
                                            <input type="time" id="hora" name="hora" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Descreva o ocorrido</label>
                                            <textarea id="descricao" name="descricao" class="form-control">
                                                Insira <em>a descrição</em> <u>do ocorrido</u> <strong>aqui</strong>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                                    </div>
                                    <?php 
                                        if(isset($_POST['cadastrar']))
                                            require_once("../admin/CadastroOcorrencia.php"); 
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
<!-- Summernote -->
<script src="../../plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

  })
</script>

<?php include("../includes/footer.php") ?>