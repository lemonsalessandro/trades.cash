<?php
session_start();
require_once('conexao.php');

$array = array($_SESSION['idUsuario']);

try {
    $query = $conexao->prepare("select valorCarteira FROM usuario WHERE idUsuario = ?");
    $query->execute($array);
    $resultado = $query->fetch();
    echo json_encode($resultado);
    
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}


?>