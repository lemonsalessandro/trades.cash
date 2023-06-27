<?php
session_start();
if (isset($_SESSION['logado'])) {
    header('location: trades.php');
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=poppins">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/login.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <a href="index.php"><img id="logo" src="img/logo2.png" alt="logo trades.cash" draggable="false"></a>
            </figure>
        </header>

        <section class="sessao-contato" id="contatos">
            <div class="contato">
                <h1>Entre com sua conta</h1>
                <form action="includes/logica/logica.php" method="post">
                    <div class="input-group">
                        <input type="email" class="field" id="email" name="email" required>
                        <label for="email" class="field-label">E-mail</label>
                    </div>
                    <div class="input-group">
                        <input type="password" class="field" id="senha" name="senha" required>
                        <label for="senha" class="field-label">Senha</label>
                    </div>
                    <button type="submit" id="entrar" name='entrar' value="Entrar">Entrar</button>
                    <div class="buttons">
                        <a href="cadastro.php" id="criar">Criar Conta</a>
                        <a href="esqueciSenha.php" id="esqueceuSenha">Esqueci minha senha</a>
                    </div>
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