<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />

    <link rel="stylesheet" href="css/cadastro.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <a href="index.php"><img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false"></a>
            </figure>
        </header>

        <section class="sessao-contato" id="contatos">
            <div class="contato">
                <h1>Crie sua conta</h1>
                <h4 id="error-msg"></h4>
                <form action="includes/logica/logica.php" method="post" enctype="multipart/form-data" id="formCadastro">
                    <div class="input-group">
                        <input type="text" class="field" id="nome" name="nome" required>
                        <label for="nome" class="field-label">Nome</label>
                    </div>
                    <div class="input-group">
                        <input type="email" class="field" id="email" name="email" required>
                        <label for="email" class="field-label">E-mail</label>
                    </div>
                    <div class="input-group">
                        <input type="password" class="field" id="senha" name="senha" minlength="5" required>
                        <label for="senha" class="field-label">Senha</label>
                    </div>
                    <div class="input-group" id="input-foto">
                        <input type="file" class="field" id="fotoPerfil" name="fotoPerfil">
                        <label for="fotoPerfila" class="field-label">Foto de Perfil</label>
                    </div>
                    <button type="submit" id="criarConta" name='criarConta' value="Criar">Criar Conta</button>
                </form>
            </div>
            <div class="session-msg-login">
                <h3 id='msg-login-h3'>
                    <?php
                    session_start();
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
        <script src="js/validacao.js"></script>
</html>