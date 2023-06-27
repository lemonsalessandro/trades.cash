<?php
session_start();
include_once('includes/logica/funcoes.php');
include_once('includes/logica/conexao.php');

if (!isset($_SESSION['logado'])) {
    header('location: login.php');
}


$array = array($_SESSION['idUsuario']);
$tradeCount = listarNumeroTrocas($conexao, $array);

if ($_SESSION['idUsuario'] == 1) {
    header('location: painelAdm.php');
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/darkMode.css">
    <title>Trades.Cash</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <figure>
                <a href="trades.php">
                    <img id="logo" src="img/logo2.png" alt="logo trades cash" draggable="false">
                </a>
            </figure>


            <div class="right-side">
                <button id="darkModeToggle" class="main"><i class="fa-solid fa-circle-half-stroke"></i></button>
                <div class="dropdown">
                    <button class="dropbtn"><i class="fa-solid fa-bars"></i></button>
                    <div class="dropdown-content">
                        <a href="trades.php">Trocar</a>
                        <a href="venda.php">Vender</a>
                        <a href="compra.php">Comprar</a>
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

        <div class="navbar">
            <nav>
                <ul>
                    <li class="white"><a href="trades.php" class="link">Trocar</a></li>
                    <li class="white"><a href="venda.php" class="link">Vender</a></li>
                    <li class="white"><a href="compra.php" class="link">Comprar</a></li>
                </ul>
            </nav>

            <button id="supportBtn"><i class="fa-solid fa-headset"></i> Suporte</button>
        </div>
        <div class="content">
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
            <div class="content-wrapper">
                <div class="main-text">
                    <h1>Informações Pessoais</h1>
                </div>
                <div class="info-wrapper">
                    <div class="name-photo">
                        <div class="image-text">
                            <img src="<?php echo 'img/profileImg/' . $_SESSION['imgPerfil'] ?>" draggable="false" />
                            <div class="text-info">
                                <h2>
                                    <?php echo $_SESSION['nome']; ?>
                                </h2>
                                <span>Membro desde:
                                    <?php echo $_SESSION['dataCadastro']; ?>
                                </span> <br>
                                <span>Trocas efetuadas: <?php echo $tradeCount['count(*)'] ?>
                                </span>
                            </div>
                        </div>


                        <div class="carteira">
                            <i class="fa-solid fa-wallet"></i>
                            <span id='amount'>
                            </span>
                            <div id="addFunds">
                                <i class="fa-solid fa-circle-plus"><button>Adicionar Saldo</button></i>
                            </div>
                        </div>
                    </div>
                    <div class="email">
                        <h3 for="email">Email: </h3>
                        <span>
                            <?php echo $_SESSION['email']; ?>
                        </span>
                    </div>
                </div>

                <form id="addFundsModal" class="modal" method="post" action="includes/logica/logica.php">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Adicionar Saldo</h2>
                        <input id="inputFund" type="number" placeholder="Quanto deseja adicionar? Ex: 120" name="qtd" required>
                        <p id="msg"></p>
                        <div class="payMethod">
                            <input type="radio" name="method" id="pix">
                            <label for="pix">PIX</label>
                            <input type="radio" name="method" id="paypal">
                            <label for="paypal">Paypal</label>
                            <input type="radio" name="method" id="debito">
                            <label for="debito">Débito</label>
                        </div>
                        <button id="btnFunds" name="addFunds">Confirmar</button>
                    </div>
                </form>

                <div class="buttons-wrapper">
                    <div class="buttons">
                        <h3><i class="fa-solid fa-user"></i> Conta</h3>
                        <a href="alterarDados.php" id="changeData">Atualizar meus dados</a>

                        <a href="alterarSenha.php" id="changePassword" name='changePassword'>Alterar minha
                            Senha</a>
                        <a href="includes/logica/apagarConta.php" id="deleteAccount" name='deleteAccount'>Deletar minha
                            conta</a>
                    </div>


                    <div class="userItems">
                        <h3><i class="fa-solid fa-box"></i> Inventário</h3>
                        <a id="editItem" href="inventarios.php">Editar Inventário</a>
                        <a id="tradeHistory" href="historicoTroca.php">Histórico de Trocas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/carteira.js"></script>
<script src="js/profile.js"></script>
<script src="js/localStorage.js"></script>

</html>