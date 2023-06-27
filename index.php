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
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/style.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <img id="logo" src="img/logo2.png" alt="logo trades.cash" draggable="false">
            </figure>

            <div class="right-side">
                <div class="button">
                    <a id='btn-login-header' href="login.php">Fazer login</a>
                </div>
            </div>
        </header>

        <div class="img">
            <div class="info-wrapper">
                <ul id="infos">
                    <li>
                        <i class="fa-solid fa-clock"></i>
                        <p>Negocie suas skins em poucos segundos</p>
                    </li>
                    <li>
                        <i class="fa-sharp fa-solid fa-dollar-sign"></i>
                        <p>Receba mais dinheiro com nossas taxas reduzidas</p>
                    </li>
                    <li>
                        <i class="fa-solid fa-headset"></i>
                        <p>Suporte online para atendimento rápido</p>
                    </li>
                    <li>
                        <i class="fa-solid fa-chart-simple"></i>
                        <p>Milhões de negociações bem sucedidas</p>
                    </li>
                </ul>
            </div>

            <div class="main-skins">
                <div class="knife">
                    <img src="img/home/bayonet.png" alt="baioneta" draggable="false">
                </div>

                <div class="p2000">
                    <img src="img/home/p2000.png" alt="p2000" draggable="false">
                </div>

                <div class="ak47">
                    <img src="img/home/ak.png" alt="ak47" draggable="false">
                </div>
            </div>

        </div>
        <div class="text">
            <div class="text-content">
                <h1 id="main-text">Negociar se tornou mais fácil</h1>
                <p>
                    Oferecemos uma ampla variedade de opções para personalizar o seu inventário, com preços acessíveis e
                    uma plataforma de compras segura e fácil de usar.
                </p>
                <p>Junte-se à nossa comunidade agora mesmo para dar um upgrade em seu jogo!</p>

                <a id="main-btn" href="login.php">Fazer login</a>
            </div>
            <ul class="box-area">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
        <footer class="footer">

            <ul id="patrocinadores">
                <li id="steelseries">
                    <img src="img/home/steelseries.png" alt="steelseries logo" draggable="false">
                </li>
                <li id="gamersclub">
                    <img src="img/home/gamersclub.png" alt="gamersclub logo" draggable="false">
                </li>
                <li id="intel">
                    <img src="img/home/intel.png" alt="intel logo" draggable="false">
                </li>
            </ul>

            <div id="sticker">
                <figure>
                    <img id="trustpilot" src="img/home/trustpilot.png" alt="trustpilot sticker" draggable="false">
                </figure>
            </div>
        </footer>
    </div>
</body>

</html>