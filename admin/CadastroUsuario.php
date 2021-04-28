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
$senha = 'infoinova';
$areaAtuacao = $_POST['areaAtuacao'];
$areaInteresse = $_POST['areaInteresse'];
$telefone = $_POST['telefone'];
$empresa = $_POST['empresa'];
$primeiroLogin = true;

if (!empty($nome) && !empty($cpf) && !empty($rg) && 
!empty($dataNascimento) && ($responsavel != "''") && ($telResponsavel != "''") && !empty($bairro) && !empty($endereco) && 
!empty($municipio) && !empty($email) && !empty($areaAtuacao) && 
!empty($areaInteresse) &&  !empty($telefone)) {

    $upload_dir = "../images/usuarios//";
    $file = $upload_dir . hash("md5", $cpf) . ".png";

    require_once("DB.php");

    if ($empresa == '...')
        $empresa = 'null';
    
    if (isset($_POST['socio']) && $empresa != 'null')
        $socio = true;
    else
        $socio = 'null';

    if (isset($_POST['perfil']))
        if (!isset($_SESSION['admin']) && ($_POST['perfil'] == "1" || $_POST['perfil'] == "2"))
            $perfilUsuario = false;
        else
            $perfilUsuario = $_POST['perfil'];
    else
        $perfilUsuario = 3; // Usuario

    $senhaHash = password_hash($senha, PASSWORD_BCRYPT);

    // verifica se email existe
    $sql = "SELECT usu_email FROM usuario WHERE usu_email = '".$email."'";
    $query = mysqli_query($connect, $sql);

    if (!mysqli_num_rows($query)) {
        $sql = "INSERT INTO usuario (usu_id, pu_id, emp_id, usu_nome, usu_rg, usu_cpf, usu_data_nascimento, usu_responsavel, usu_tel_responsavel, usu_endereco, usu_cep, usu_bairro, usu_municipio, usu_area_atuacao, usu_area_interesse, usu_telefone, usu_email, usu_senha, usu_socio, usu_primeiro_login) VALUES (null, ".$perfilUsuario.", ".$empresa.", '".$nome."', '".$rg."', '".$cpf."', '".$dataNascimento."',".$responsavel.",".$telResponsavel.", '".$endereco."', '".$cep."', '".$bairro."', '".$municipio."', '".$areaAtuacao."', '".$areaInteresse."', '".$telefone."', '".$email."', '".$senhaHash."', ".$socio.", ".$primeiroLogin.")";
        $query = mysqli_query($connect, $sql);
        if (!$perfilUsuario)
            echo "<div class='alert alert-info' role='alert'>Você nao tem permissão para cadastrar um usuário com esse perfil.</div>";
        else {
            if ($query){
                echo "<div class='alert alert-success' role='alert'> Usuario cadastrado</div>";
                // upload imagem
                    $img = $_POST['img64'];
                    $img = str_replace('data:image/png;base64,', '', $img);
                    $img = str_replace(' ', '+', $img);
                    $data = base64_decode($img);
                    $success = file_put_contents($file, $data);
                    print $success ? $file : 'Unable to save the file.';
                //fim upload
            }
            else
                echo "<div class='alert alert-info' role='alert'>Nao foi possivel cadastar usuario</div>";
        }
    } else
        echo "<div class='alert alert-info' role='alert'>Email ja cadastrado</div>";
} else {
    echo "<div class='alert alert-warning' role='alert'>Preencha todos os campos</div>";
}