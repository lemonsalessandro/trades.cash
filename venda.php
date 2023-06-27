<?php
session_start();
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conexao.php');

if (!isset($_SESSION['logado'])) {
    header('location: login.php');
}

$skinUrl = 'https://steamcommunity-a.akamaihd.net/economy/image/';
$skinTeste = '-9a81dlWLwJ2UUGcVs_nsVtzdOEdtWwKGZZLQHTxDZ7I56KU0Zwwo4NUX4oFJZEHLbXH5ApeO4YmlhxYQknCRvCo04DEVlxkKgpovrG1eVcwg8zJfAJA4N21n7-blvngO77DqWdY781lxL_DpIjxjgLk_EI9NzihIoCdd1RoN1vTrAO7k-vng5S6u8icySRquic8pSGKCka2ZP8';
$array = array($_SESSION['idUsuario']);

$itensUser = listarItens($conexao, $array);

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
    <link rel="stylesheet" href="css/venda.css">
    <link rel="stylesheet" href="css/darkMode.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">

            <div class="logo-and-nav">
                <a href="trades.php">
                    <img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false">
                </a>

                <div class="header-nav">
                    <a href="trades.php">Trocar</a>
                    <a href="compra.php">Comprar</a>
                </div>
            </div>

            <div class="right-side">
                <button id="darkModeToggle"><i class="fa-solid fa-circle-half-stroke"></i></button>

                <div class="carteira">
                    <i id='walletIcon' class="fa-solid fa-wallet"></i>
                    <span id='amount'>
                        <?php echo ' R$ ' . $_SESSION['valorCarteira']; ?>
                    </span>
                </div>

                <div class="dropdown">
                    <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
                    <div class="dropdown-content">
                        <a href="trades.php">Trocar</a>
                        <a href="venda.php">Vender</a>
                        <a href="compra.php">Comprar</a>
                        <a href="profile.php">Perfil</a>
                        <a href="includes/logica/logout.php">Logout</a>
                    </div>
                </div>

                <div class="photo-header">
                    <a href="profile.php"><img src="<?php echo 'img/profileImg/' . $_SESSION['imgPerfil'] ?>"
                            draggable="false" /></a>
                </div>

                <a href="includes/logica/logout.php" id='logout'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </header>


        <div class="content">
            <div id="popup" class="popup">
                <h1>[ERRO]</h1>
                <p>Você precisa selecionar no mínimo um item para vender!</p>
            </div>

            <form class="content-wrapper" method="POST" action="includes/logica/logica.php">
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
                <div class="userItems">
                    <?php
                    foreach ($itensUser as $itemUser) {
                        ?>
                        <div class="label-wrapper">
                            <label class="item" for='itemUser[]'>
                                <div class="upper-text">
                                    <span>
                                        <?php echo $itemUser['estado'] ?>
                                    </span>
                                </div>
                                <img draggable="false" class="item-img" src="<?php echo $skinUrl . $itemUser['itemImg'] ?>">
                                <div class="bottom-text">
                                    <span>
                                        <?php echo 'R$ ' . $itemUser['preco'] ?>
                                    </span>
                                </div>

                                <input id="inspectLink" type="hidden" value="<?php echo $itemUser['inspectInGame'] ?>">
                                <input id="itemRaridade" type="hidden" value="<?php echo $itemUser['raridade'] ?>">
                                <input id="itemType" type="hidden" value="<?php echo $itemUser['tipo'] ?>">
                                <input id="skinName" type="hidden" value="<?php echo $itemUser['nomeSkin'] ?>">

                                <input type="checkbox" name="itemUser[]" class="inputItem" id="checkItem"
                                    value="<?php echo $itemUser['idItem'] ?>">
                            </label>
                            <div class="inspectItem"><i class="fa-solid fa-magnifying-glass"></i>Inspecionar</div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
                <div class="tradeBtnWrapper">
                    <button type="submit" id="trade-btn" name='sellItems'>Vender Selecionados</button>
                </div>
            </form>

            <div class="modal-item">
                <div class="modal-content">
                    <div id="modalClose"><i id="modalCloseIcon" class="fa-solid fa-xmark"></i></div>
                    <img id="imgModal" draggable="false" src="<?php echo $skinUrl . $skinTeste ?>">
                    <div class="skinInfo">
                        <div class="textInfo">
                            <h2 id="skinNameModal"></h2>
                        </div>
                        <div id="textInfoWrapper">
                            <div class="textInfo">
                                <span class="static">Estado</span>
                                <span id="skinEstadoModal"></span>
                            </div>
                            <div class="textInfo">
                                <span class="static">Tipo</span>
                                <span id="skinTypeModal"></span>
                            </div>
                            <div class="textInfo">
                                <span class="static">Raridade</span>
                                <span id="skinRaridadeModal"></span>
                            </div>
                        </div>
                        <div id="precoModal">
                            <h1 id="skinPriceModal"></h1>
                            <a class="inspectInGame" href="">
                                <span>Ver no Jogo</span>
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
</body>
<script src="js/venda.js"></script>
<script src="js/localStorage.js"></script>

</html>