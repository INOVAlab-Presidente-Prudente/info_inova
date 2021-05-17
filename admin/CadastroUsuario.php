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
$complemento = $_POST['complemento'];
$estado = $_POST['estado'];

if (!empty($nome) && !empty($cpf) && !empty($rg) && 
!empty($dataNascimento) && ($responsavel != "''") && ($telResponsavel != "''") && !empty($bairro) && !empty($endereco) && 
!empty($municipio) && !empty($email) && !empty($areaAtuacao) && 
!empty($areaInteresse) &&  !empty($telefone) && !empty($estado)) {

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
        $sql = "INSERT INTO usuario (usu_id, pu_id, emp_id, usu_nome, usu_rg, usu_cpf, usu_data_nascimento, usu_responsavel, usu_tel_responsavel, usu_endereco, usu_cep, usu_bairro, usu_municipio, usu_area_atuacao, usu_area_interesse, usu_telefone, usu_email, usu_senha, usu_socio, usu_primeiro_login, usu_complemento, usu_estado) VALUES (null, ".$perfilUsuario.", ".$empresa.", '".$nome."', '".$rg."', '".$cpf."', '".$dataNascimento."',".$responsavel.",".$telResponsavel.", '".$endereco."', '".$cep."', '".$bairro."', '".$municipio."', '".$areaAtuacao."', '".$areaInteresse."', '".$telefone."', '".$email."', '".$senhaHash."', ".$socio.", ".$primeiroLogin.", '".$complemento."', '".$estado."')";
        $query = mysqli_query($connect, $sql);
        if (!$perfilUsuario){
            echo "<div class='col alert alert-warning alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-exclamation-triangle'></i>&nbspPermissão Negada!</h5>
                    <p>Você nao tem permissão para cadastrar um usuário com esse perfil.</p>
                  </div>";
        }
        
        else {
            if ($query){
                echo "<div class='col alert alert-success alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='fas fa-check'></i>&nbspUsuário Cadastrado!</h5>
                            <p>O usuário foi cadastrado com sucesso!.</p>
                      </div>";

                // upload imagem
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
                //fim upload
            }
            else{
                //  var_dump(mysqli_error($connect));
                if(strpos(mysqli_error($connect), "uplicate entry"))
                    echo "<div class='col alert alert-info alert-dismissible'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <h5><i class='fas fa-info'></i>&nbspUsuário já Cadastrado!</h5>
                        <p>Usuário já está cadastrado no sistema!.</p>
                    </div>";
                else 
                echo "<div class='col alert alert-info alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h5><i class='fas fa-info'></i>&nbspUsuário não Cadastrado!</h5>
                    <p> Novo usuário não foi cadastrado, tente novamente!.</p>
                </div>";
            }
        }
    }
    else{
        echo "
        <div class='col alert alert-info alert-dismissible'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <h5><i class='icon fas fa-ban'></i> Não é possivel efetuar o cadastro!</h5>
                <p>Este email já está em uso no sistema. Novo usuário não foi cadastrado.!</p>
        </div>";
    }
} 
else {
    echo "<div class='col alert alert-warning alert-dismissible'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <h5><i class='fas fa-exclamation-triangle'></i>&nbspNão foi possível cadastar o(a) usuário!</h5>
        <p>Preencha todos os campos!.</p>
    </div>";
}


