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

    if (!empty($cep) && !empty($email) && !empty($complemento) && !empty($estado) && !empty($municipio) && !empty($bairro) && !empty($endereco) && !empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao) && !empty($nomeFantasia)) {
        $sql = "UPDATE empresa SET 
        emp_razao_social = ?,
        emp_cnpj = ?,  
        emp_telefone = ?, 
        emp_area_atuacao = ?, 
        mod_id = ?, 
        emp_nome_fantasia = ?, 
        emp_residente = ?, 
        emp_municipio = ?, 
        emp_endereco = ?, 
        emp_complemento = ?, 
        emp_bairro = ?, 
        emp_estado = ?, 
        emp_cep = ?, 
        emp_email = ?
        WHERE emp_cnpj = '".$_GET['cnpj']."'"; 
        
        $prepare = mysqli_prepare($connect, $sql);
        $bindParam = mysqli_stmt_bind_param($prepare, "ssssisisssssss",
            $razaoSocial,
            $cnpj,
            $telefone,
            $areaAtuacao,
            $modalidade,
            $nomeFantasia,
            $residente,
            $municipio,
            $endereco,
            $complemento,
            $bairro,
            $estado,
            $cep,
            $email);
        //var_dump($prepare);
        //var_dump($bindParam);
        if (mysqli_stmt_execute($prepare)){
            header("location: ../pages/visualizarEmpresa.php?cnpj=".$cnpj."&empresa_alterada=true");
        }
        else{
            header("location: ?cnpj=".$_GET['cnpj']."&empresa_nao_alterada=true");
        }
    } else {
        header("location: ?cnpj=".$_GET['cnpj']."&falta_dados=true");
    }