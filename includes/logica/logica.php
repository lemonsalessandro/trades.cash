<?php
require_once('conexao.php');
require_once('funcoes.php');
require_once('config_upload.php');
require_once('email/envia_email.php');

session_start();

//                  USUARIO                 //

#CADASTRO USUARIO
if (isset($_POST['criarConta']) && $_SESSION['logado'] == false) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $fotoPerfil = $_FILES['fotoPerfil']['name'];
    $fotoTamanho = $_FILES['fotoPerfil']['size'];
    $fotoTemp = $_FILES['fotoPerfil']['tmp_name'];
    if (!empty($fotoPerfil)) {
        if (file_exists("../../img/profileImg/$fotoPerfil")) {
            $_SESSION["msg"] = "Esse arquivo já existe no nosso banco de dados!";
            header('location:../../cadastro.php');
        }

        if ($fotoTamanho > $tamanho_bytes) {
            $_SESSION["msg"] = "O arquivo que voce esta tentando fazer upload é muito grande!";
            header('location:../../cadastro.php');
        }

        $ext = strrchr($fotoPerfil, '.');
        if (!in_array($ext, $extensoes_validas)) {
            $_SESSION["msg"] = "As extensões de arquivo válidas são: JPG, JPEG e PNG!";
            header('location:../../cadastro.php');
        }

        $uploadFoto = move_uploaded_file($fotoTemp, "../../img/profileImg/$fotoPerfil");
    } else {
        $fotoPerfil = 'profile.png';
    }

    //procura no banco de dados se ja existe o mesmo email cadastrado
    $array = array($email);
    $verificacao = buscarPessoa($conexao, $array);

    if ($verificacao) {
        $_SESSION["msg"] = "Este email ja está cadastrado!";
        header('location:../../cadastro.php');
    } else {
        $array = array($nome, $email, $senha, $fotoPerfil);
        $usuario = cadastrarUsuario($conexao, $array);
        $hash = base64_encode($email);
        $assunto = "Confirmação de cadastro";
        $link = "<a style='color: #fff' href='http://localhost/VAMO%20DALE/Projeto%203%20SEM/includes/logica/confirmarConta.php?h=" . $hash . "'> Clique para confirmar sua conta! </a>";
        $mensagem = "<tr><td style='padding: 10px 20px;' align='center'; bgcolor='#856cf0'>";
        $mensagem .= "Email de Confirmação <br>" . $link . "</td></tr>";
        $flag;

        $retorno = enviaEmail($email, $mensagem, $assunto, $link);

        if ($usuario) {
            $_SESSION["msg"] = "Agora só falta confirmar sua conta no email cadastrado!";
            header('location:../../login.php');
        }
    }
}

#LOGIN
if (isset($_POST['entrar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $array = array($email);

    $pessoa = buscarPessoa($conexao, $array);
    if ($pessoa) {
        if (password_verify($senha, $pessoa['senha'])) {
            if ($pessoa['status'] == 0) {
                $_SESSION['msg'] = '[ERRO] Você precisa confirmar seu cadastro primeiro!';
                header('location:../../login.php');
            } else if ($pessoa['status'] == 1) {

                $_SESSION['logado'] = true;
                $_SESSION['idUsuario'] = $pessoa['idUsuario'];
                $_SESSION['nome'] = $pessoa['nome'];
                $_SESSION['email'] = $pessoa['email'];
                $_SESSION['imgPerfil'] = $pessoa['imagemPerfil'];
                $_SESSION['valorCarteira'] = $pessoa['valorCarteira'];
                $_SESSION['dataCadastro'] = date('d/m/Y', strtotime($pessoa['dataCadastro']));

                if ($pessoa['idUsuario'] == '1') {
                    header('location:../../painelAdm.php');
                } else {
                    header('location:../../trades.php');
                }


            }
        } else {
            $_SESSION['msg'] = '[ERRO] Senha incorreta!';
            header('location:../../login.php');
        }

    } else {
        $_SESSION['msg'] = '[ERRO] Email não encontrado!';
        header('location:../../login.php');
    }
}

#ALTERAR DADOS
if (isset($_POST['criarConta']) && $_SESSION['logado'] == true) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $fotoPerfil = $_FILES['fotoPerfil']['name'];
    $fotoTamanho = $_FILES['fotoPerfil']['size'];
    $fotoTemp = $_FILES['fotoPerfil']['tmp_name'];

    if (!empty($fotoPerfil)) {
        if (file_exists("../../img/profileImg/$fotoPerfil")) {
            $_SESSION["msg"] = "Esse arquivo já existe no nosso banco de dados!";
            header('location:../../alterarDados.php');
        }

        if ($fotoTamanho > $tamanho_bytes) {
            $_SESSION["msg"] = "O arquivo que voce esta tentando fazer upload é muito grande!";
            header('location:../../alterarDados.php');
        }

        $ext = strrchr($fotoPerfil, '.');
        if (!in_array($ext, $extensoes_validas)) {
            $_SESSION["msg"] = "As extensões de arquivo válidas são: JPG, JPEG e PNG!";
            header('location:../../alterarDados.php');
        }

        $uploadFoto = move_uploaded_file($fotoTemp, "../../img/profileImg/$fotoPerfil");
    } else {
        //se nao for enviada nenhuma imagem de perfil eu salvo a foto antiga para mandar novamente
        $array = array($_SESSION['email']);
        $backupImg = buscarPessoa($conexao, $array);
        if ($backupImg) {
            $fotoPerfil = $backupImg['imagemPerfil'];
        }
    }

    //verificacao de email
    $array = array($email);
    $verificacao = buscarPessoa($conexao, $array);

    //email nao pode existir no banco de dados (ao menos que seja o que esta sendo usado)
    if ($verificacao == true && $email != $_SESSION['email']) {
        $_SESSION["msg"] = "Este email ja está cadastrado!";
        header('location:../../alterarDados.php');
    } else {
        $array = array($nome, $email, $fotoPerfil, $_SESSION['idUsuario']);
        $usuario = atualizarDados($conexao, $array);
        if ($usuario) {
            $array2 = array($email);
            $pessoa = buscarPessoa($conexao, $array2);
            $_SESSION['idUsuario'] = $pessoa['idUsuario'];
            $_SESSION['nome'] = $pessoa['nome'];
            $_SESSION['email'] = $pessoa['email'];
            $_SESSION['imgPerfil'] = $pessoa['imagemPerfil'];
            $_SESSION["msg"] = "Seus dados foram salvos!";
            header('location:../../alterarDados.php');
        }
    }
}

if (isset($_POST['alterarSenha'])) {

    $idUsuario = $_SESSION['idUsuario'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $array = array($senha, $idUsuario);

    $retorno = alterarSenha($conexao, $array);

    if ($retorno) {
        $_SESSION['msg'] = 'Senha alterada com sucesso!';
        header('location: ../../alterarSenha.php');
    }

}


if (isset($_POST['esqueciSenha'])) {
    $email = $_POST['email'];

    $array = array($email);
    $usuario = buscarPessoa($conexao, $array);

    if ($usuario) {
        $senha = $usuario['senha'];
        $hash = base64_encode($email . $senha);
        $array = array($hash, $email);

        $retornoToken = adicionarToken($conexao, $array);

        if ($retornoToken) {
            $assunto = "Recuperação de senha";
            $link = "<a style='color: #fff' href='http://localhost/VAMO%20DALE/Projeto%203%20SEM/includes/logica/recuperarSenha.php?h=" . $hash . "'> Clique para recuperar sua senha! </a>";
            $mensagem = "<tr><td style='padding: 10px 20px;' align='center'; bgcolor='#856cf0'>";
            $mensagem .= "Link de recuperação <br>" . $link . "</td></tr>";

            $retorno = enviaEmail($email, $mensagem, $assunto, $link);
        }

        if ($retorno) {
            $_SESSION['msg'] = 'Verifique seu email para efetuar a recuperação de senha!';
        } else {
            $_SESSION['msg'] = '[ERRO] Tente novamente!';
        }
    } else {
        $_SESSION['msg'] = '[ERRO] Email não encontrado!';
    }
    header('location: ../../esqueciSenha.php');
}


//ADICIONAR SALDO CARTEIRA
if (isset($_POST['addFunds'])) {
    $qtd = $_POST['qtd'];

    echo $qtd;

    $array = array($qtd, $_SESSION['idUsuario']);

    $retorno = adicionaSaldo($conexao, $array);

    $array = array($_SESSION['email']);
    $usuario = buscarPessoa($conexao, $array);

    $_SESSION['valorCarteira'] = $usuario['valorCarteira'];

    if ($retorno) {
        $_SESSION['msg'] = 'Saldo adicionado com sucesso!';

        $email = $_SESSION['email'];
        $assunto = "Aviso de pagamento";
        $mensagem = "<tr><td style='padding: 10px 20px;' align='center'; bgcolor='#5eb590'>";
        $mensagem .= "Olá, <br> Viemos avisar que foi efetuado um pagamento na sua conta no valor de <strong>R$" . $qtd . "</strong> na data de <strong>" . date('d/m/Y') . "</strong></td></tr>";

        $retorno = enviaEmail($email, $mensagem, $assunto, $link = null);
    } else {
        $_SESSION['msg'] = 'Ocorreu um erro!';
    }
    header('location: ../../profile.php');

}

//                  ITENS                 //

if (isset($_POST['deletarItem'])) {
    $idItem = $_POST['idItem'];

    if ($_SESSION['idUsuario'] == 1) {
        $array = array($idItem);
        $retorno = deletarItemSite($conexao, $array);
    } else {
        $nomeSkin = $_POST['nomeSkin'];
        $idUser = $_SESSION['idUsuario'];
        $array = array($idItem, $idUser);
        $retorno = deletarItem($conexao, $array);
    }
    if ($retorno) {
        $_SESSION['msg'] = 'Item excluído';
        header('location: ../../inventarios.php');
    }
}


//troca user x site
if (isset($_POST['tradeItem'])) {
    $itensUser = $_POST['itemUser'];
    $itensSite = $_POST['itemSite'];
    $idUsuario = $_SESSION['idUsuario'];
    $array = array($idUsuario);

    $accUser = 0;
    $accSite = 0;
    $validado = false;

    foreach ($itensUser as $itemUser) {
        $array = array($itemUser, $_SESSION['idUsuario']);
        $retorno = avaliarItensUser($conexao, $array);
        $accUser += $retorno['preco'];
    }
    echo $accUser . ' <br> ITENS USER <br>';

    foreach ($itensSite as $itemSite) {
        $array = array($itemSite);
        $retorno = avaliarItensSite($conexao, $array);
        $accSite += $retorno['preco'];
    }

    echo $accSite . '<br> ITENS SITE <br>';

    if ($accUser >= $accSite) {
        $restoCarteira = $accUser - $accSite;
        $array = array($restoCarteira, $_SESSION['idUsuario']);
        adicionaSaldo($conexao, $array);
        $array = array($_SESSION['email']);
        $retornoBusca = buscarPessoa($conexao, $array);
        $_SESSION['valorCarteira'] = $retornoBusca['valorCarteira'];
        $validado = true;

    } else if ($accUser < $accSite) {
        $array = array($_SESSION['email']);
        $retornoBusca = buscarPessoa($conexao, $array);
        $totalUser = $accUser + $retornoBusca['valorCarteira'];

        if ($totalUser > $accSite) {
            $restoCarteira = $totalUser - $accSite;
            $array = array($restoCarteira, $_SESSION['idUsuario']);
            $retorno = atualizaSaldo($conexao, $array);
            $array = array($_SESSION['email']);
            $retornoBusca = buscarPessoa($conexao, $array);
            $_SESSION['valorCarteira'] = $retornoBusca['valorCarteira'];
            $validado = true;
        } else {
            $_SESSION['msg'] = 'Você não possui saldo disponível!';
            header('location: ../../trades.php');
            die();
        }

    }

    if ($validado) {

        try {
            $conexao->beginTransaction();

            // inserir a troca na tabela troca
            $sql = "INSERT INTO troca (idUsuario) VALUES (?)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$idUsuario]);

            // pega o id da troca inserida
            $idTroca = $conexao->lastInsertId();

            // insere os itens do usuario na tabela troca_itens
            $sql = "INSERT INTO troca_itens (idTroca, idItem, idItemSite) VALUES (?, ?, NULL)";
            $stmt = $conexao->prepare($sql);

            foreach ($itensUser as $idItem) {
                $stmt->execute([$idTroca, $idItem]);
            }

            // insere os itens do site na tabela "troca_itens"
            $sql = "INSERT INTO troca_itens (idTroca, idItem, idItemSite) VALUES (?, NULL, ?)";
            $stmt = $conexao->prepare($sql);

            foreach ($itensSite as $idItemSite) {
                $stmt->execute([$idTroca, $idItemSite]);
            }

            $conexao->commit();
            echo "Troca realizada com sucesso!";

        } catch (PDOException $e) {
            $conexao->rollback();
            echo "Erro na troca: " . $e->getMessage();
        }
    }

    //remocao dos itens do inventario do usuario e adicao no inventario do site
    foreach ($itensUser as $item) {
        $array = array($item, $idUsuario);
        $retornoSkinsUser = listarItensTrade($conexao, $array);
        $nome = $retornoSkinsUser['nomeSkin'];
        $tipo = $retornoSkinsUser['tipo'];
        $estado = $retornoSkinsUser['estado'];
        $raridade = $retornoSkinsUser['raridade'];
        $img = $retornoSkinsUser['itemImg'];
        $preco = $retornoSkinsUser['preco'];
        $inspectInGame = $retornoSkinsUser['inspectInGame'];

        $array2 = array($nome, $tipo, $estado, $raridade, $img, $preco, $inspectInGame);
        adicionaItemSite($conexao, $array2);
        vendeItem($conexao, $array);
    }


    //remocao dos itens do inventario do site e adicao no inventario do usuario
    foreach ($itensSite as $item) {
        $array = array($item);
        $retornoSkinsSite = listarItemsSiteTrade($conexao, $array);
        $nome = $retornoSkinsSite['nomeSkin'];
        $tipo = $retornoSkinsSite['tipo'];
        $estado = $retornoSkinsSite['estado'];
        $raridade = $retornoSkinsSite['raridade'];
        $img = $retornoSkinsSite['itemImg'];
        $preco = $retornoSkinsSite['preco'];
        $inspectInGame = $retornoSkinsSite['inspectInGame'];
        $array2 = array($nome, $tipo, $estado, $raridade, $img, $preco, $idUsuario, $inspectInGame);
        adicionaItemUser($conexao, $array2);
        ocultarItemSite($conexao, $array);
    }

    $_SESSION['msg'] = 'Troca Efetuada com Sucesso!';
    header('location: ../../trades.php');
}


if (isset($_POST['sellItems'])) {
    $itensUser = $_POST['itemUser'];

    $accUser = 0;

    $user = $_SESSION['idUsuario'];
    $username = $_SESSION['nome'];
    foreach ($itensUser as $item) {
        $array = array($item, $user);

        $retorno = avaliarItensUser($conexao, $array);
        if ($retorno) {
            $accUser += $retorno['preco'];
            $sellItem = vendeItem($conexao, $array);
        }
    }
    $array = array($accUser, $user);
    $addFund = adicionaSaldo($conexao, $array);

    $array = array($_SESSION['email']);
    $retornoBusca = buscarPessoa($conexao, $array);

    $email = $_SESSION['email'];
    $assunto = "Venda efetuada com sucesso";
    $mensagem = "<tr><td style='padding: 10px 20px;' align='center'; bgcolor='#5eb590'>";
    $mensagem .= "Olá, " . $username . "<br> .Viemos avisar que sua venda de <strong>R$ " . $accUser . "</strong> foi realizada com sucesso na data de <strong>" . date('d/m/Y') . "</strong> 
    <br>Seus créditos já estão disponíveis na sua carteira. Aproveite!</td></tr>";

    $retorno = enviaEmail($email, $mensagem, $assunto, $link = null);

    $_SESSION['valorCarteira'] = $retornoBusca['valorCarteira'];

    if (sizeof($itensUser) > 1) {
        $_SESSION['msg'] = "SEUS ITENS FORAM VENDIDOS COM SUCESSO";
    } else {
        $_SESSION['msg'] = "SEU ITEM FOI VENDIDO COM SUCESSO";
    }

    header("location: ../../venda.php");
}


//comprar itens
if (isset($_POST['buyItems'])) {

    $itemsSite = $_POST['itemSite'];
    $user = $_SESSION['idUsuario'];


    $accSite = 0;

    foreach ($itemsSite as $itemSite) {
        $array = array($itemSite);
        $skins = avaliarItensSite($conexao, $array);
        $accSite += $skins['preco'];
        echo $accSite;
    }

    if ($accSite > $_SESSION['valorCarteira']) {
        $_SESSION['msg'] = "Você não possui créditos suficientes!";
        header("location: ../../compra.php");
        die();
    } else {
        foreach ($itemsSite as $itemSite) {
            $array = array($itemSite);
            $skin = avaliarItensSite($conexao, $array);

            $arrayItem = array($skin['nomeSkin'], $skin['tipo'], $skin['estado'], $skin['raridade'], $skin['itemImg'], $skin['preco'], $user);
            compraItem($conexao, $arrayItem);

            deletarItemSite($conexao, $array);
        }
    }

    $restoCarteira = $_SESSION['valorCarteira'] - $accSite;

    $array = array($restoCarteira, $_SESSION['idUsuario']);
    atualizaSaldo($conexao, $array);

    $array = array($_SESSION['email']);
    $retornoBusca = buscarPessoa($conexao, $array);
    $_SESSION['valorCarteira'] = $retornoBusca['valorCarteira'];

    if (sizeof($itemsSite) > 1) {
        $_SESSION['msg'] = "SUCESSO! SEUS ITENS JÁ ESTÁ DISPONÍVEIS NO SEU INVENTÁRIO";
    } else {
        $_SESSION['msg'] = "SUCESSO! SEU ITEM JÁ ESTÁ DISPONÍVEL NO SEU INVENTÁRIO";
    }

    header("location: ../../compra.php");
}




?>