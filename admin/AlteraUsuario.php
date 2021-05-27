<?php
if(!isset($_SERVER['HTTP_REFERER']))
    header('location: /');


$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$dataNascimento = $_POST['dataNascimento'];
$idade = $_POST['idade'];
if($idade < 18){
    $responsavel = $_POST['responsavel'];
    $telResponsavel = $_POST['telResponsavel'];
    
}else{
    $responsavel = $telResponsavel = null;
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
$complemento = $_POST['complemento'];
$estado = $_POST['estado'];

if ($empresa == '...')
    $empresa = null;
    
if (isset($_POST['socio']) && $empresa != 'null')
    $socio = true;
else
    $socio = null;

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

    $upload_dir = "../images/usuarios//";
    $file = $upload_dir . hash("md5", $cpf) . ".png";

    $sql = "UPDATE usuario SET pu_id = ?, emp_id = ?, usu_nome = ?, usu_rg = ?, usu_cpf = ?, usu_data_nascimento = ?, usu_responsavel = ?, usu_tel_responsavel = ?, usu_endereco = ?, usu_cep = ?, usu_bairro = ?, usu_municipio = ?, usu_area_atuacao = ?, usu_area_interesse = ?, usu_telefone = ?, usu_email = ?, usu_senha = ?, usu_socio = ?, usu_complemento = ?, usu_estado = ? WHERE usu_cpf = '".$_GET['cpf']."'";
    $prepare = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($prepare, "iisssssssssssssssiss",
    $perfilUsuario,
    $empresa,
    $nome,
    $rg,
    $cpf,
    $dataNascimento,
    $responsavel,
    $telResponsavel,
    $endereco,
    $cep,
    $bairro,
    $municipio,
    $areaAtuacao,
    $areaInteresse,
    $telefone,
    $email,
    $senha,
    $socio,
    $complemento,
    $estado);

    if (!$perfilUsuario)
            header("location: ../pages/visualizarUsuario.php?cpf=".$_GET['cpf']."&erro=permissao_negada");
    else {
        if (mysqli_stmt_execute($prepare)){
            if($_GET['cpf'] == $_SESSION['cpf']) {
                $_SESSION['cpf'] = $_POST['cpf'];
                rename('../images/usuarios/'.hash("md5", $_GET['cpf']).'.png', '../images/usuarios/'.hash("md5", $_SESSION['cpf']).'.png');
            }   

            $img = $_POST['img64'];
            if($img!=""){
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $success = file_put_contents($file, $data);
                // print $success ? $file : 'Unable to save the file.';
            }

            if ($_FILES['uploadFoto']) {
                $uploadfile = "../images/usuarios/" . hash("md5", $cpf) . ".png";
                move_uploaded_file($_FILES['uploadFoto']['tmp_name'], $uploadfile);
            }
            
            header("location: ../pages/visualizarUsuario.php?cpf=".$cpf."&usuario_alterado=true");
        }
            
        else
            header("location: ../pages/visualizarUsuario.php?cpf=".$_GET['cpf']."&usuario_nao_alterado=true");
    }
} else {
    header("location: ../pages/visualizarUsuario.php?cpf=".$_GET['cpf']."&usuario_nao_alterado=true");
}