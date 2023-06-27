<?php
session_start();

if ($_SESSION['idUsuario'] != 1) {
    header('location: ../../index.php');
}

require_once('conexao.php');

$allSkins = json_decode(file_get_contents("../../js/itens.json"), true);

$data = json_decode(file_get_contents("php://input"), true);

$skins = $allSkins['skins'];


foreach ($data as $id) {
    $skinData = $skins[$id];

    $array = array(
        $skinData['nome'], $skinData['tipo'],
        $skinData['estado'], $skinData['raridade'],
        $skinData['imagem'], $skinData['valor'], $skinData['inspectInGame']
    );

    $query = $conexao->prepare("insert into inventario_site (nomeSkin,tipo,estado,raridade,itemImg, preco, inspectInGame) values (?,?,?,?,?,?,?)");
    $result = $query->execute($array);

}

?>