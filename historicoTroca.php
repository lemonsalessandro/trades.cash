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
    <link rel="stylesheet" href="css/historicoTroca.css">
    <link rel="stylesheet" href="css/darkMode.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <a href="trades.php">
                <img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false">
            </a>
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
        $array = array($_SESSION['idUsuario']);
        $itens = historicoTroca($conexao, $array);
        ?>

        <div class="content">
            <?php
            foreach ($itens as $item) {

                ?>
                <div class="item">
                    <h4 id="itemUser">
                        <?php echo $item['nomeSkinsUsuario'] ?>
                        
                    </h4>
                    <h1>
                        <i class="fa-solid fa-arrow-right-arrow-left"></i>
                        <p>
                            <?php echo "Data: " . date('d/m/Y', strtotime($item['data'])); ?>
                        </p>
                    </h1>
                    <h4 id="itemSite">
                        <?php echo $item['nomeSkinsSite'] ?>
                    </h4>
                </div>

                <?php
            }
            ?>

        </div>

    </div>
</body>
<script src="js/localStorage.js"></script>

</html>