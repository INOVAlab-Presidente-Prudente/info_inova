<?php include("../includes/header.php")?>
<body class="hold-transition sidebar-mini" onload="document.title='Admin Page | Ocorrências'">
    <?php include("../includes/navbar.php") ?>
    <?php include("../includes/sidebar.php") ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Ocorrências</h1>
                        </div>

                    </div>
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h1 class="card-title">Todas Ocorrências de</strong></h1>
                                </div>
                                <div class="card-body">
                                <button type='button' class='btn btn-info w-100' onclick="window.location.href = 'cadastrarOcorrencia.php?usu_id=<?=$_GET['usu_id']?>'">Nova ocorrência</button>
                                <?php
                                    if(isset($_GET['excluido']))
                                        echo "excluido"; //ALERT EXCLUIDO
                                    if(isset($_GET['erroExcluir']))
                                        echo "erro ao excluir"; //ALERT
                                    require_once("../admin/DB.php");
                                    $sql = "SELECT usu_nome FROM usuario WHERE usu_id = '".$_GET['usu_id']."'";
                                    $query = mysqli_query($connect, $sql);
                                    if($query){
                                        $row = mysqli_fetch_assoc($query);
                                        echo "<h2>".$row['usu_nome']."</h2><br><br>";

                                        $sql = "SELECT * FROM ocorrencia WHERE usu_id = '".$_GET['usu_id']."'";
                                        $query = mysqli_query($connect, $sql);
                                        $res = mysqli_fetch_array($query);
                                        if($res == null)
                                            echo "".$row['usu_nome']." não possui ocorrência";
                                        while($res != null){
                                            echo "".$res['oc_data']."<br> Ocorrência: ".$res['oc_descricao']."<br>\n";
                                            echo "<button name='alterar' onclick=\"window.location.href='alterarOcorrencia.php?oc_id=".$res['oc_id']."'\">Alterar</button>";
                                            echo "<button name='excluir' onclick=\"excluir(".$res['oc_id'].",".$_GET['usu_id'].")\">
                                                    Excluir
                                                  </button><br><br>";
                                            $res = mysqli_fetch_array($query);
                                        }
                                    }else echo "Usuario não encontrado";
                                ?>
                                
                                </div>
                                <div class="card-footer">
                                
                                </div>
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