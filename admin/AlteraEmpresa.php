<?php
    if(!isset($_SERVER['HTTP_REFERER']))
        header('location: /');
    
    $razaoSocial = $_POST['razaoSocial'];
    $cnpj = $_POST['cnpj'];
    $telefone = $_POST['telefone'];
    $areaAtuacao = $_POST['areaAtuacao'];
    $modalidade = $_POST['modalidade'];
    $nomefantadia = $_POST['nomefantasia'];

    if (!empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao) && !empty($modalidade)) {
        $sql = "UPDATE empresa SET emp_razao_social = '".$razaoSocial."', emp_cnpj = '".$cnpj."', emp_telefone = '".$telefone."', emp_area_atuacao = '".$areaAtuacao."', mod_id = '".$modalidade."', emp_nome_fantasia = '".$nomefantasia."' WHERE emp_cnpj = '".$_GET['cnpj']."';";
        $query = mysqli_query($connect, $sql);
        if ($query)
            header("location: ?cnpj=".$cnpj."&empresa_alterada=true");
        else
            header("location: ?cnpj=".$_GET['cnpj']."&empresa_nao_alterada=true");
    }
