<?php
session_start();
include_once('funcoes.php');
include_once('conexao.php');

if ($_GET['h']) {
    $h = base64_decode($_GET['h']);
    $_SESSION["msg"] = '';

    $array = array($h);
    $pessoa = buscarPessoa($conexao, $array);

    if ($pessoa) {
        $array = array($pessoa['idUsuario']);
        $retorno = confirmarConta($conexao, $array);
        if ($retorno) {
            $_SESSION["msg"] = "Sua conta foi confirmada com sucesso!";
        } else {
            $_SESSION["msg"] = 'Ops! Ocorreu um erro com sua confirmação, por favor tente novamente!';
        }
    } 

    header("location:../../login.php");

}