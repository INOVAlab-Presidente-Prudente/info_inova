<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$nomeFantasia = $_POST['nomeFantasia'];
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];
$areaAtuacao = $_POST['areaAtuacao'];
$residente = $_POST['residente'] != NULL ? 1 : 0;
$modalidade = $residente ? $_POST['modalidade'] : null;
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$municipio = $_POST['municipio'];
$bairro = $_POST['bairro'];
$estado = $_POST['estado'];
$complemento = $_POST['complemento'];
$email = $_POST['email'];
$numero = $_POST['numero'];

if (!empty($cep) && !empty($email) && !empty($estado) && !empty($municipio) && !empty($bairro) && !empty($endereco) && !empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao)) {
    require_once("DB.php");
    $sql = "INSERT INTO empresa (emp_razao_social, emp_cnpj, emp_telefone, mod_id, emp_nome_fantasia, emp_residente, emp_municipio,  emp_endereco, emp_bairro, emp_estado, emp_area_atuacao, emp_cep, emp_email, emp_complemento, emp_numero) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $prepare = mysqli_prepare($connect, $sql);
    $bindParam = mysqli_stmt_bind_param($prepare, "sssisissssssssi",
                $razaoSocial,
                $cnpj,
                $telefone,
                $modalidade,
                $nomeFantasia,
                $residente,
                $municipio,
                $endereco,
                $bairro,
                $estado,
                $areaAtuacao,
                $cep,
                $email,
                $complemento,
                $numero);

    if (mysqli_stmt_execute($prepare)) {
        header("location: ../pages/consultarEmpresa.php?empresa_cadastrada=true");
    } else {
        if(strpos(mysqli_error($connect), "uplicate entry")){
            echo "<div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-info'></i>&nbspEmpresa j?? Cadastrada!</h5>
                <p> Este CNPJ j?? encontra-se cadastrado no sistema</p>
            </div>";
        }
        else {
            echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-ban'></i> Ocorreu um erro ao cadastrar, tente novamente ou contate um Administrador!</h5>
          </div>";
        }
            
    }
} else {
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspN??o foi poss??vel cadastar a empresa!</h5>
            <p>Preencha todos os campos!.</p>
         </div>";
}

