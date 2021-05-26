<?php
    if(!isset($_SERVER['HTTP_REFERER']))
        header('location: /');
    
    $nomeFantasia = $_POST['nomeFantasia'];
    $razaoSocial = $_POST['razaoSocial'];
    $cnpj = $_POST['cnpj'];
    $telefone = $_POST['telefone'];
    $areaAtuacao = $_POST['areaAtuacao'];
    $residente = $_POST['residente'] != NULL? 1: 0;
    $modalidade = $residente ? $_POST['modalidade'] : "null";
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $municipio = $_POST['municipio'];
    $bairro = $_POST['bairro'];
    $estado = $_POST['estado'];
    $complemento = $_POST['complemento'];
    $email = $_POST['email'];

    if (!empty($cep) && !empty($email) && !empty($complemento) && !empty($estado) && !empty($municipio) && !empty($bairro) && !empty($endereco) && !empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao) && !empty($modalidade) && !empty($nomeFantasia)) {
        $sql = "UPDATE empresa SET 
        emp_razao_social = '".$razaoSocial."',
        emp_cnpj = '".$cnpj."',  
        emp_telefone = '".$telefone."', 
        emp_area_atuacao = '".$areaAtuacao."', 
        mod_id = ".$modalidade.", 
        emp_nome_fantasia = '".$nomeFantasia."', 
        emp_residente = '".$residente."', 
        emp_municipio = '".$municipio."', 
        emp_endereco = '".$endereco."', 
        emp_complemento = '".$complemento."', 
        emp_bairro = '".$bairro."', 
        emp_estado = '".$estado."', 
        emp_cep = '".$cep."', 
        emp_email = '".$email."'  
        WHERE emp_cnpj = '".$_GET['cnpj']."'"; 
        $query = mysqli_query($connect, $sql);
        if ($query){
            header("location: ../pages/visualizarEmpresa.php?cnpj=".$cnpj."&empresa_alterada=true");
        }
        else{
            //var_dump($sql);
           //var_dump(mysqli_error($connect));
            //die();
            header("location: ?cnpj=".$_GET['cnpj']."&empresa_nao_alterada=true");
        }
    } else {
        header("location: ?cnpj=".$_GET['cnpj']."&falta_dados=true");
    }