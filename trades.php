<?php
session_start();
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conexao.php');

if (!isset($_SESSION['logado'])) {
    header('location: login.php');
}

$skinUrl = 'https://steamcommunity-a.akamaihd.net/economy/image/';
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
    <link rel="stylesheet" href="css/trades.css">
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
                    <a href="venda.php">Vender</a>
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

        <div class="content">
            <div id="popup" class="popup">
                <h1>[ERRO]</h1>
                <p>Você precisa selecionar ao menos um item de cada inventário!</p>
            </div>

            <form class="content-wrapper" method="POST" action="includes/logica/logica.php">
                <div class="userInventory">
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
                                    <img draggable="false" class="item-img"
                                        src="<?php echo $skinUrl . $itemUser['itemImg'] ?>">
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

                <div class="filters">

                    <div class="tradeBtnWrapper">
                        <button type="submit" id="trade-btn" name='tradeItem'>TROCAR</button>
                    </div>

                    <div class="filtersOptions">
                        <div class="price">
                            <h3>PREÇO MAX.</h3>
                            <input type="range" name='price' min="0" max="10000" value="0" class="priceInput"
                                id="priceRange">
                            <p id="priceValue">R$</p>
                        </div>
                        <div class="checkboxesFilters">
                            <div class="checkFilter">
                                <input type="checkbox" name="tipo[]" value="Faca" id="faca">
                                <label for="faca">Faca</label>
                            </div>
                            <div class="checkFilter">
                                <input type="checkbox" name="tipo[]" value="Pistola" id="pistola">
                                <label for="pistola">Pistola</label>
                            </div>
                            <div class="checkFilter">
                                <input type="checkbox" name="tipo[]" value="Rifle" id="rifles">
                                <label for="rifles">Rifles</label>
                            </div>
                            <div class="checkFilter">
                                <input type="checkbox" name="tipo[]" value="Luva" id="luvas">
                                <label for="luvas">Luvas</label>
                            </div>
                            <div class="checkFilter">
                                <input type="checkbox" name="tipo[]" value="SMG" id="smg">
                                <label for="smg">SMG</label>
                            </div>
                        </div>

                        <div class="buttonsFilter">
                            <button id="applyFilters" name="applyFilters">Aplicar Filtros</button>
                            <button type="reset" id="resetFilters">Resetar Filtros</button>
                        </div>
                    </div>

                </div>

                <div class="siteInventory">
                    <div class="siteItems">

                    </div>
                </div>
            </form>
        </div>
</body>
<script src="js/trades.js"></script>
<script src="js/localStorage.js"></script>

</html>