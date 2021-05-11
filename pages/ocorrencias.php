<?php include("../includes/header.php")?>
<?php include("../includes/primeirologin.php")?>
<?php include("../includes/permissoes.php")?>
<body class="hold-transition sidebar-mini" onload="document.title=' Ocorrências';">
    <?php include("../includes/navbar.php"); $output = ""; $typeAlert = ""; $icon = ""; $title = "";?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ocorrências</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">    <a href="/pages/adminPage.php">Home</a> </li>
                                <li class="breadcrumb-item">    <a href="/pages/consultarUsuario.php">Consultar Usuário</a> </li>
                                <li class="breadcrumb-item active">   <a href="/pages/ocorrencias.php?usu_id=<?=$_GET['usu_id']?>">Registro de Ocorrências</a>    </li>
                            </ol>
                        </div>

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header h-50">
                                    <div class="card-title w-100 ">
                                        <?php
                                            if(isset($_GET['excluido'])){
                                                $output = "Ocorrência excluída com sucesso.";
                                                $icon = "fa-check";
                                                $typeAlert = "success";
                                                $title = "Sucesso!";
                                                $alertSetted = true;

                                            }
                                            if(isset($_GET['erroExcluir'])){
                                                $output = "Erro ao excluir ocorrência.";
                                                $icon = "fa-exclamation-triangle";
                                                $typeAlert = "warning";
                                                $title = "Erro!";
                                                $alertSetted = true;
                                            }
                                            if(isset($_GET['alterado'])){  
                                                $output = "Ocorrência alterada com sucesso.";
                                                $icon = "fa-check";
                                                $typeAlert = "success";
                                                $title = "Sucesso!";
                                                $alertSetted = true;
                                            }
                                            if(isset($_GET['error'])){  
                                                $output = "Erro ao alterar a ocorrência.";
                                                $icon = "fa-exclamation-triangle";
                                                $typeAlert = "warning";
                                                $title = "Erro!";
                                                $alertSetted = true;
                                            }
                                            if(isset($alertSetted))
                                            {
                                                echo "<div class='alert alert-".$typeAlert." alert-dismissible'>
                                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                                    <h5><i class='icon fas ".$icon."'></i>".$title."</h5>
                                                        <p>".$output."</p>
                                                </div>";
                                            }
                                        ?> 
                                    </div>
                                </div>
                                <div class="card-body">
                                    <button type='button' class='btn btn-info w-100 mb-4' onclick="window.location.href = 'cadastrarOcorrencia.php?usu_id=<?=$_GET['usu_id']?>'">Nova ocorrência</button>
                                    <div class="container">
                                    <?php    
                                        require_once("../admin/DB.php");
                                        $sql = "SELECT usu_nome FROM usuario WHERE usu_id = '".$_GET['usu_id']."'";
                                        $query = mysqli_query($connect, $sql);
                                        if($query){
                                            $row = mysqli_fetch_assoc($query);?>
                                            <h4>Todas Ocorrências de <strong><?=$row['usu_nome']?></strong></h4>
                                        
                                            <div class="row align-items-start justify-content-start mx-auto">
                                                <?php 
                                                    $sql = "SELECT * FROM ocorrencia WHERE usu_id = '".$_GET['usu_id']."'";
                                                    $query = mysqli_query($connect, $sql);
                                                    $res = mysqli_fetch_array($query);
                                                    if($res == null)
                                                        echo " <h3>O usuário não possui ocorrência! </h3>";//".$row['usu_nome']."
                                                    
                                                    while($res != null){
                                                        $data = substr($res['oc_data'],0,-9);
                                                        $horario = substr($res['oc_data'],-9,6);
                                                        
                                                        /*
                                                            Columns rules
                                                                Para Celulares	Para Tablets	Para Desktops	Para Telas Grandes
                                                                .col-xs-*	     .col-sm-*	      .col-md-*	        .col-lg-*
                                                        */
                                                        echo "<div class='col-md-3 col-xs-4 col-sm-3 col-lg-4 mb-2'>"; // mr-3
                                                            echo "<div class='card card-outline card-info' style='width:14rem;'>";
                                                            echo "<div class='card-body'>";
                                                                echo "<div class='row'> <h5 class='card-title'> <strong>Data:</strong> ".$data."</h5></div>  <div class='row'><h6 class=' card-subtitle mb-3 text-muted mt-1'><strong>Horario:</strong>".$horario." </h6></div>  <div class='row card-text text-justify text-truncate' style='display: block;'><div class='font-weight-bold'>Ocorrência: </div> ".$res['oc_descricao']."</div>";
                                                                    echo "<div class='mt-1 row justify-content-between'>";
                                                                        echo "<a class='col-4 btn btn-light w-25' type='link' name='alterar' onclick=\"window.location.href='alterarOcorrencia.php?oc_id=".$res['oc_id']."'\"><i class='fas fa-edit'></i></a>";
                                                                        echo "<a class='col-4 btn btn-light w-25' type='link' name='excluir' onclick=\"excluir(".$res['oc_id'].",".$_GET['usu_id'].")\"><i class='fas fa-trash'></i></a>";
                                                                        echo "</div>";
                                                                    echo "</div>";
                                                            echo "</div>";
                                                        echo "</div>";
                                                    
                                                        $res = mysqli_fetch_array($query);
                                                        
                                                    }
                                                }else $output = "Usuario não encontrado";
                                                ?>
                                            </div>
                                        </div>
                                </div>
                                <!-- <div class="card-footer">
                                
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        function excluir(oc_id, usu_id){
            if(confirm("Deseja mesmo excluir esta ocorrência?")) //substituir pela modal
                window.location.href="../admin/ExcluiOcorrencia.php?usu_id="+usu_id+"&oc_id="+oc_id;
        }
    </script>
<?php 
    include("../includes/footer.php");
?>