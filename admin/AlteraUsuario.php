<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');


$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$dataNascimento = $_POST['dataNascimento'];
$idade = $_POST['idade'];
if($idade < 18){
    $responsavel = "'".$_POST['responsavel']."'";
    $telResponsavel = "'".$_POST['telResponsavel']."'";
    
}else{
    $responsavel = $telResponsavel = "null";
}
$cep = $_POST['cep'];
$bairro = $_POST['bairro'];
$endereco = $_POST['endereco'];
$municipio = $_POST['municipio'];
$email = $_POST['email'];
$areaAtuacao = $_POST['areaAtuacao'];
$areaInteresse = $_POST['areaInteresse'];
$telefone = $_POST['telefone'];
$empresa = $_POST['empresa'];
$senha = $row['usu_senha'];

if ($empresa == '...')
    $empresa = 'null';
    
if (isset($_POST['socio']) && $empresa != 'null')
    $socio = true;
else
    $socio = 'null';

if (isset($_POST['perfil']))
    if (isset($_SESSION['coworking']) && $_POST['perfil'] != '1' && $cpf == $_SESSION['cpf'])
        $perfilUsuario = $_POST['perfil'];
    else if (!isset($_SESSION['admin']) && ($_POST['perfil'] == "1" || $_POST['perfil'] == "2"))
        $perfilUsuario = false;
    else
        $perfilUsuario = $_POST['perfil'];
else
    $perfilUsuario = 3; // Usuario

if (!empty($nome) && !empty($cpf) && !empty($rg) && 
!empty($dataNascimento) && ($responsavel != "''") && ($telResponsavel != "''") && !empty($cep) &&
!empty($bairro) && !empty($endereco) && 
!empty($municipio) && !empty($email) && !empty($areaAtuacao) && 
!empty($areaInteresse) &&  !empty($telefone)) {

    if($_GET['cpf'] == $_SESSION['cpf']) {
        $primeiroNome = explode(" ", $nome)[0];
        $sobrenome = explode(" ", $nome)[count(explode(" ", $nome))-1];
        $_SESSION['nome'] =  $primeiroNome . " " . $sobrenome;
    }   

    $sql = "UPDATE usuario SET pu_id = ".$perfilUsuario.", emp_id = ".$empresa.", usu_nome = '".$nome."', usu_rg = '".$rg."', usu_cpf = '".$cpf."', usu_data_nascimento = '".$dataNascimento."', usu_responsavel = ".$responsavel.", usu_tel_responsavel = ".$telResponsavel.", usu_endereco = '".$endereco."', usu_cep = '".$cep."', usu_bairro = '".$bairro."', usu_municipio = '".$municipio."', usu_area_atuacao = '".$areaAtuacao."', usu_area_interesse = '".$areaInteresse."', usu_telefone = '".$telefone."', usu_email = '".$email."', usu_senha = '".$senha."', usu_socio = ".$socio." WHERE usu_cpf = '".$_GET['cpf']."'";
    $query = mysqli_query($connect, $sql);
    if (!$perfilUsuario)
            header("location: ?cpf=".$_GET['cpf']."&erro=permissao_negada");
    else {
        if ($query)
            header("location: ?cpf=".$cpf."&usuario_alterado=true");
        else
            header("location: ?cpf=".$_GET['cpf']."&usuario_nao_alterado=true");
    }
} else {
    echo "Preencha todos os campos";
}