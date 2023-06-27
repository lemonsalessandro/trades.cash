<?php
require_once('../includes/logica/conexao.php');

try {
    $query = $conexao->prepare("select * from inventario_site where oculto != 1 order by preco desc");
    if ($query->execute()) {
        $itens = $query->fetchAll();
        echo json_encode($itens);
    } else {
        return false;
    }

} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();

}



?>