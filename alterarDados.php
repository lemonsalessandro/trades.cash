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
                    <a href="profile.php"><img src="<?php echo 'img/profileImg/' . $_SESSION['imgPerfil'] ?>"
                            draggable="false" /></a>
                </div>

                <a href="includes/logica/logout.php" id='logout'><i class="fa-solid fa-right-from-bracket"></i></a>

            </div>
        </header>

        <section class="sessao-contato" id="contatos">
            <div class="contato">
                <h1>Alterar Dados</h1>
                <form action="includes/logica/logica.php" method="post" enctype="multipart/form-data">
                    <div class="input-group">
                        <input type="text" class="field" id="nome" name="nome" value='<?php echo $_SESSION['nome']; ?>'
                            required>
                        <label for="nome" class="field-label">Nome</label>
                    </div>
                    <div class="input-group">
                        <input type="email" class="field" id="email" name="email"
                            value='<?php echo $_SESSION['email']; ?>' required>
                        <label for="email" class="field-label">E-mail</label>
                    </div>
                    <div class="input-group" id="input-foto">
                        <input type="file" class="field" id="fotoPerfil" name="fotoPerfil">
                        <label for="fotoPerfila" class="field-label">Foto de Perfil</label>
                    </div>
                    <button type="submit" id="criarConta" name='criarConta' value="Criar">Alterar Dados</button>
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