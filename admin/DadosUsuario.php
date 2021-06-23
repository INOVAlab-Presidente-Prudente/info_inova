<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

require_once("DB.php");

$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : false;
$uID = isset($dados['usu_id']) ? $dados['usu_id'] : "";
$cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : false;
$eID = isset($dados['emp_id']) ? $dados['emp_id'] : "";

if ($cpf || $uID) {
    $sql = "SELECT  usu_nome as nome,
                    usu_cpf as doc,
                    usu_rg as rg,
                    usu_cep as cep,
                    usu_endereco as endereco,
                    usu_bairro as bairro,
                    usu_municipio as municipio,
                    usu_email as email,
                    usu_telefone as telefone,
                    usu_id FROM usuario WHERE usu_id = '$uID' OR usu_cpf = '$cpf'";
} else if ($cnpj || $eID) {
    $sql = "SELECT  emp_id,
                    emp_razao_social as nome,
                    emp_cnpj as doc,
                    emp_cep as cep,
                    emp_endereco as endereco,
                    emp_bairro as bairro,
                    emp_municipio as municipio,
                    emp_email as email,
                    emp_telefone as telefone 
                    FROM empresa WHERE emp_id = '$eID' OR emp_cnpj = '$cnpj'";
}

$query = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($query);

if (($cpf || $uID) && $row == null) {
    echo "<script>document.getElementById('alert-pj').style.display = 'none';</script>";
    echo "<script>document.getElementById('alert-pf').style.display = 'block';</script>";
} else if (($cnpj || $eID) && $row == null){
    echo "<script>document.getElementById('alert-pf').style.display = 'none';</script>";
    echo "<script>document.getElementById('alert-pj').style.display = 'block';</script>";
} else {
    echo "<script>document.getElementById('alert-pf').style.display = 'none';</script>";
    echo "<script>document.getElementById('alert-pj').style.display = 'none';</script>";
}
?>

<div class="row col-md-12 invoice-info mb-1" >
    <?php if($row != null): ?>
        <div class="col-md-6 invoice-col">
            <b>Nome/Razão Social:</b>&nbsp;<?=htmlspecialchars($row["nome"])?><br/>
            <b>Email:</b>&nbsp;<?=htmlspecialchars($row["email"])?><br/>
            <?php 
                if(isset($row["rg"])){?>
                    <b>RG:</b>&nbsp;<?=htmlspecialchars($row["rg"])?><br/>
                    <b>CPF:</b>&nbsp;<?=htmlspecialchars($row['doc'])?><br/>
            <?php
                }
                else{?>
                    <b>CNPJ:</b>&nbsp;<?=htmlspecialchars($row['doc'])?><br/>
            <?php }?>
            <b>Telefone:</b>&nbsp;<?=htmlspecialchars($row["telefone"])?><br/>
        </div>
        <div class="col-md-6 invoice-col">
            <b>CEP:</b>&nbsp;<?=htmlspecialchars($row["cep"])?><br/>
            <b>Endereço:</b>&nbsp;<?=htmlspecialchars($row["endereco"])?><br/>
            <b>Bairro:</b>&nbsp;<?=htmlspecialchars($row["bairro"])?><br/>
            <b>Munícipio:</b>&nbsp;<?=htmlspecialchars($row["municipio"])?><br/>
        </div>
        <script>
            document.getElementById("data-user").style.display = "flex";
            document.getElementById("idUsuario").value = '<?=isset($row['usu_id']) ? $row['usu_id'] : ""?>';
            document.getElementById("idEmpresa").value = '<?=isset($row['emp_id']) ? $row['emp_id'] : ""?>';
        </script>
    <?php else:?>
        <script>
            document.getElementById("data-user").style.display = "none";
        </script>
    <?php endif?>
</div>