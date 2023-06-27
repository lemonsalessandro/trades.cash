<?php
session_start();
require_once('conexao.php');

if ($_SESSION['idUsuario'] == 1) {
    header('location: ../../index.php');
}

$allSkins = json_decode(file_get_contents("../../js/itens.json"), true);

$data = json_decode(file_get_contents("php://input"), true);

$skins = $allSkins['skins'];

foreach ($data as $id) {
    $skinData = $skins[$id];

    $array = array(
        $skinData['nome'], $skinData['tipo'],
        $skinData['estado'], $skinData['raridade'],
        $skinData['imagem'], $skinData['valor'],
        $_SESSION['idUsuario'], $skinData['inspectInGame']
    );

    $query = $conexao->prepare("insert into inventario_usuarios (nomeSkin,tipo,estado,raridade,itemImg, preco, idUsuario, inspectInGame) values (?,?,?,?,?,?,?,?)");
    $result = $query->execute($array);

}

?>