<?php
require_once('conexao.php');
require_once('funcoes.php');

// filtragem dos itens do site

$data = json_decode(file_get_contents("php://input"), true);
$tipo = $data['filterActive'];

$price = intval($data['maxPrice']);

$results = array();

if ($price == 0) {
    foreach ($tipo as $cadaTipo) {
        $query = $conexao->prepare('SELECT * FROM inventario_site WHERE tipo = ? order by preco desc');
        $query->execute([$cadaTipo]);
        $eachResult = $query->fetchAll(PDO::FETCH_ASSOC);
        $results = array_merge($results, $eachResult);
    }
} else {
    foreach ($tipo as $cadaTipo) {
        $query = $conexao->prepare('SELECT * FROM inventario_site WHERE tipo = ? and preco < ? order by preco desc');
        $query->execute([$cadaTipo, $price]);
        $eachResult = $query->fetchAll(PDO::FETCH_ASSOC);
        $results = array_merge($results, $eachResult);
    }
}
echo json_encode($results);

?>