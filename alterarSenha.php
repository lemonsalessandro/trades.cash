<?php

session_start();

if (!isset($_SESSION['logado']) && !isset($_SESSION['recuperar']) ) {
    header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <a href="trades.php"><img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false"></a>
            </figure>

            <div class="right-side">
                <div class="photo-header">
                <?php 
                         if(isset($_SESSION['imgPerfil'])){
                ?>
                <a href="profile.php"><img src="<?php echo 'img/profileImg/' . $_SESSION['imgPerfil'] ?>" draggable="false" /></a>
                <?php
                    }
                ?>
                </div>
                <?php 
                         if(isset($_SESSION['logado'])){
                ?>
                <a href="includes/logica/logout.php" id='logout'><i class="fa-solid fa-right-from-bracket"></i></a>
                <?php
                    }
                ?>
            </div>
        </header>

        <section class="sessao-contato" id="contatos">
            <div class="contato">
                <h1>Atualizar Senha</h1>
                <form action="includes/logica/logica.php" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="password" class="field" id="password" name="senha" required minlength="4">
                        <label for="password" class="field-label">Digite sua nova senha</label>
                    </div>
                    <button type="submit" id="criarConta" name='alterarSenha' value="Criar">Atualizar Senha</button>
                </form>
            </div>
            <div class="session-msg-login">
                <h3>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                </h3>
            </div>
        </section>
    </div>
</body>
</html>