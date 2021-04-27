<?php
    if(!isset($_SERVER['HTTP_REFERER']))
        header('location: /');
    
    $razaoSocial = $_POST['razaoSocial'];
    $cnpj = $_POST['cnpj'];
    $telefone = $_POST['telefone'];
    $areaAtuacao = $_POST['areaAtuacao'];

    if (!empty($razaoSocial) && !empty($cnpj) && !empty($telefone) && !empty($areaAtuacao)) {
        $sql = "UPDATE empresa SET emp_razao_social = '".$razaoSocial."', emp_cnpj = '".$cnpj."', emp_telefone = '".$telefone."', emp_area_atuacao = '".$areaAtuacao."' WHERE emp_cnpj = '".$_GET['cnpj']."';";
        $query = mysqli_query($connect, $sql);
        if ($query)
            header("location: ?cnpj=".$cnpj."&empresa_alterada=true");
        else
            header("location: ?cnpj=".$_GET['cnpj']."&empresa_nao_alterada=true");
    }
