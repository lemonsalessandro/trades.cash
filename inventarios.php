<?php
session_start();
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conexao.php');

if (!isset($_SESSION['logado'])) {
    header('location: login.php');
}

$skinUrl = 'https://steamcommunity-a.akamaihd.net/economy/image/';

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
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/inventario.css">
    <link rel="stylesheet" href="css/darkMode.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false">
            </figure>

            <div class="right-side">
                <button id="darkModeToggle"><i class="fa-solid fa-circle-half-stroke"></i></button>
                <div class="back">

                    <a id="btnBack" href="profile.php">Voltar</a>
                </div>

                <div class="photo-header">
                    <a href="profile.php"><img src="<?php echo 'img/profileImg/' . $_SESSION['imgPerfil'] ?>"
                            draggable="false" /></a>
                </div>

                <a href="includes/logica/logout.php" id='logout'><i class="fa-solid fa-right-from-bracket"></i></a>

            </div>
        </header>

        <?php
        if ($_SESSION['idUsuario'] != '1') {
            $array = array($_SESSION['idUsuario']);
            $itens = listarItens($conexao, $array);
        } else {
            $itens = listarItensSite($conexao);
        }
        ?>

        <div class="message">
            <h3>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </h3>
        </div>

        <div class="content">
            <?php
            foreach ($itens as $item) {
                ?>
                <form method="post" action="includes/logica/logica.php" class="item">
                    <div class="info">
                        <?php
                        if ($_SESSION['idUsuario'] == 1) {
                            echo "<input type='hidden' name='idItem' value='" . $item['idItemSite'] . "'>";
                        } else {
                            echo '<input type="hidden" name="idItem" value="' . $item['idItem'] . '">';
                        }
                        ?>
                        <h4>
                            <?php echo $item['nomeSkin'] ?>
                        </h4>
                        <h4>
                            Estado:
                            <?php echo $item['estado'] ?>
                        </h4>
                        <h4>
                            Raridade:
                            <?php echo $item['raridade'] ?>
                        </h4>
                        <h4>
                            Preço: R$
                            <?php echo $item['preco'] ?>
                        </h4>
                    </div>
                    <img draggable="false" src="<?php echo $skinUrl . $item['itemImg'] ?>" alt="skin">
                    <button type="submit" name="deletarItem" id="deletarItem"><i class="fa-solid fa-trash"></i></button>
                </form>
                <?php
            }
            ?>
            <div class="addItemWrapper">
                <div class="addItem">
                    <i class="fa-solid fa-plus"></i>
                    <?php
                    if ($_SESSION['idUsuario'] != '1') {
                        echo '<a href="painelUsuario.php">Adicionar novo item</a>';
                    } else {
                        echo '<a href="painelAdm.php">Adicionar novo item</a>';
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>
</body>
<script src="js/localStorage.js"></script>

</html>