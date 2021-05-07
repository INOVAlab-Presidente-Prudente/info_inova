<?php 
    ob_start();
    include("../includes/header.php");
    include('../includes/permissoes.php');
    require_once("../admin/DB.php");

    $sql = "SELECT DATE(o.oc_data) AS dataOc, TIME(o.oc_data) AS hora, o.oc_descricao, u.usu_nome AS nome, u.usu_id AS id FROM ocorrencia o, usuario u 
            WHERE oc_id = '".$_GET['oc_id']."' AND o.usu_id = u.usu_id";
    $query = mysqli_query($connect, $sql);
     
    $row = mysqli_fetch_assoc($query);
?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Alterar Ocorrência'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Alterar Ocorrência</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/pages/adminPage.php">Home</a></li>
                                <li class="breadcrumb-item "><a href="/pages/consultarUsuario.php">Consultar Usuário</a></li>
                                <li class="breadcrumb-item "><a href="/pages/ocorrencias.php?usu_id=<?=$row['id']?>">Registro de Ocorrências</a></li>
                                <li class="breadcrumb-item active" >Alterar Ocorrência</li>
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
                                        <h1 class="card-title">Ocorrência de <strong><?=$row['nome']?></strong></h1>
                                       
                                        <!-- Inserir o require_once do backend -->
                                    </div>
                                    <div class="card-body">
                                        <input type="hidden" name="oc_id" value="<?=$_GET['oc_id']?>"/>
                                        <input type="hidden" name="usu_id" value="<?=$row['id']?>"/>
                                        
                                        <div class="form-group">
                                            <label>Data</label>
                                            <input type="date" id="dt" name="dt" class="form-control" value="<?=$row['dataOc']?>"/>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Hora</label>
                                            <input type="time" id="hora" name="hora" class="form-control" value="<?=$row['hora']?>" />
                                        </div>
                                        <div class="form-group">
                                            <label>Descreva o ocorrido</label>
                                            <textarea id="descricao" name="descricao" class="form-control"><?=$row['oc_descricao']?></textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row justify-content-center">
                                            <div class="col-2">
                                                <button type="submit" name="confirmar" class="btn btn-primary w-100">Confirmar</button>
                                            </div>
                                            
                                            <div class="col-2">
                                                <button type="submit" name="cancelar" class="btn btn-light w-100">Cancelar</button>
                                            </div>
                                        </div>

                                    </div>

                                    
                                    <?php 
                                        if(isset($_POST['confirmar']))
                                            require_once("../admin/AlteraOcorrencia.php");
                                        else if(isset($_POST['cancelar']))
                                            header("location: ocorrencias.php?usu_id=".$row['id']);
                                    ?>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

<?php include("../includes/footer.php") ?>