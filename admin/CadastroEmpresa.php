<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');

$nomeFantasia = $_POST['nomeFantasia'];
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$telefone = $_POST['telefone'];
$areaAtuacao = $_POST['areaAtuacao'];
$residente = $_POST['residente'] != NULL ? 1 : 0;
$modalidade = $residente ? "'".$_POST['modalidade']."'" : "null";
$cep = $_POST['cep'];
$endereco = $_POST['endereco'];
$municipio = $_POST['municipio'];
$bairro = $_POST['bairro'];
$estado = $_POST['estado'];
$email = $_POST['email'];


if (!empty($cep) && !empty($email) && !empty($estado) && !empty($municipio) && !empty($bairro) && !empty($endereco) && !empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao) && !empty($modalidade)) {
    require_once("DB.php");
    $sql = "INSERT INTO empresa VALUES (null, '".$razaoSocial."', '".$cnpj."', '".$telefone."', '".$areaAtuacao."', ".$modalidade.", 0, '".$nomeFantasia."', ".$residente.")";
    $sql = "INSERT INTO empresa (emp_id, emp_razao_social, emp_cpf, emp_cnpj, emp_telefone,
            mod_id, emp_nome_fantasia, emp_residente, emp_municipio, 
            emp_endereco, emp_bairro, emp_estado, emp_area_atuacao, emp_cep, emp_email) VALUES (
                null,
                '".$razaoSocial."',
                'cpf',
                '".$cnpj."',
                '".$telefone."',
                ".$modalidade.",
                '".$nomeFantasia."',
                '".$residente."',
                '".$municipio."',
                '".$endereco."',
                '".$bairro."',
                '".$estado."',
                '".$areaAtuacao."',
                '".$cep."',
                '".$email."'
            )";
    $query = mysqli_query($connect, $sql);
    if ($query) {
        echo "<div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-check'></i>&nbspEmpresa Cadastrada!</h5>
            <p>A empresa foi cadastrada com sucesso!.</p>
        </div>";
    } else {
        if(strpos(mysqli_error($connect), "Duplicate entry")){
            echo "<div class='alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='fas fa-info'></i>&nbspEmpresa já Cadastrada!</h5>
                <p> Este CNPJ já encontra-se cadastrado no sistema</p>
            </div>";
        }
        else {
            echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-ban'></i> Empresa não foi cadastrada tente novamente!</h5>
          </div>";
            var_dump(mysqli_error($connect));
        }
            
    }
} else {
    echo "<div class='alert alert-warning alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h5><i class='fas fa-exclamation-triangle'></i>&nbspNão foi possível cadastar a empresa!</h5>
            <p>Preencha todos os campos!.</p>
         </div>";
}

