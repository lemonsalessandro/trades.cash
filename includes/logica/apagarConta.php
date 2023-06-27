<?php
session_start();
require_once('conexao.php');
require_once('funcoes.php');

$arrayUser = array($_SESSION['idUsuario']);

$idsTrocasUser = selecionarTrocas($conexao, $arrayUser);

foreach($idsTrocasUser as $idTrocasUser){
    $array = array($idTrocasUser['idTroca']);
    $trocaItens = deletarTrocaItens($conexao,$array);
}

$troca = deletarTroca($conexao, $arrayUser);


$retorno = deletarConta($conexao, $arrayUser);

if ($retorno) {
    session_start();
    session_destroy();
    header('location: ../../index.php');
}

?>