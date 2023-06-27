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
    <link rel="stylesheet" href="css/painelAdm.css">
    <link rel="stylesheet" href="css/darkMode.css">

    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false">
            </figure>

            <h2>PAINEL ADM</h2>

            <div class="right-side">
            <button id="darkModeToggle"><i class="fa-solid fa-circle-half-stroke"></i></button>
                <div class="back">
                    <a id="btnBack" href="inventarios.php">Inventário</a>
                </div>

                <div class="photo-header">
                    <a href="profile.php"><img src="<?php echo 'img/profileImg/' . $_SESSION['imgPerfil'] ?>"
                            draggable="false" /></a>
                </div>
                <a href="includes/logica/logout.php" id='logout'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </header>

        <div id="msg">
            <h3>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
            </h3>
        </div>

        <div class="content-wrapper">
            <form action="adicionarItemSite.php" method="POST" id="content">
            </form>
        </div>

    </div>
</body>
<script src="js/itens.js"></script>
<script src="js/localStorage.js"></script>


</html>