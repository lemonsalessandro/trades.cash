<?php
session_start();

require_once('conexao.php');
require_once('funcoes.php');

$token = $_GET['h'];

$array = array($token);

$usuario = selecionarHash($conexao, $array);

if ($usuario){
    $_SESSION['recuperar'] = true;
    $_SESSION['idUsuario'] = $usuario['idUsuario'];
    header('location: ../../alterarSenha.php');
}




?>