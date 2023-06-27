<?php
session_start();
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conexao.php');

if (!isset($_SESSION['logado'])) {
    header('location: login.php');
}

$skinUrl = 'https://steamcommunity-a.akamaihd.net/economy/image/';
$itemsSite = listarItensSite($conexao);

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
                    <a href="venda.php">Vender</a>
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
                <p>Você precisa selecionar no mínimo um item para comprar!</p>
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
                    foreach ($itemsSite as $itemSite) {
                        ?>
                        <div class="label-wrapper">
                            <label class="item" for='itemSite[]'>
                                <div class="upper-text">
                                    <span>
                                        <?php echo $itemSite['estado'] ?>
                                    </span>
                                </div>
                                <img draggable="false" class="item-img" src="<?php echo $skinUrl . $itemSite['itemImg'] ?>">
                                <div class="bottom-text">
                                    <span>
                                        <?php echo 'R$ ' . $itemSite['preco'] ?>
                                    </span>
                                </div>

                                <input id="inspectLink" type="hidden" value="<?php echo $itemSite['inspectInGame'] ?>">
                                <input name="raridade" id="itemRaridade" type="hidden"
                                    value="<?php echo $itemSite['raridade'] ?>">
                                <input name="tipo" id="itemType" type="hidden" value="<?php echo $itemSite['tipo'] ?>">
                                <input name="nome" id="skinName" type="hidden" value="<?php echo $itemSite['nomeSkin'] ?>">

                                <input type="checkbox" name="itemSite[]" class="inputItem" id="checkItem"
                                    value="<?php echo $itemSite['idItemSite'] ?>">
                            </label>
                            <div class="inspectItem"><i class="fa-solid fa-magnifying-glass"></i>Inspecionar</div>
                        </div>

                        <?php
                    }
                    ?>
                </div>

                <div class="modal-item">
                    <div class="modal-content">
                        <div id="modalClose"><i id="modalCloseIcon" class="fa-solid fa-xmark"></i></div>
                        <img id="imgModal" draggable="false" src="<?php echo $skinUrl ?>">
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
                <div class="tradeBtnWrapper">
                    <button type="submit" id="trade-btn" name='buyItems'>Comprar Selecionados</button>
                </div>
            </form>
        </div>
</body>
<script src="js/compra.js"></script>
<script src="js/localStorage.js"></script>

</html>