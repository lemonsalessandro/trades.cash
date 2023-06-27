<?php

session_start();

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
    <link rel="stylesheet" href="css/cadastro.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <a href="trades.php"><img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false"></a>
            </figure>
        </header>

        <section class="sessao-contato" id="contatos">
            <div class="contato">
                <h1>Recuperar senha</h1>
                <form action="includes/logica/logica.php" method="post">
                    <div class="input-group">
                        <input type="email" class="field" id="password" name="email" required>
                        <label for="email" class="field-label">Digite seu email</label>
                    </div>
                    <button type="submit" id="criarConta" name='esqueciSenha'>Recuperar Senha</button>
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