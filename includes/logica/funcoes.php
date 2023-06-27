<?php
function cadastrarUsuario($conexao, $array)
{
    try {
        $query = $conexao->prepare("insert into usuario (nome, email, senha, imagemPerfil) values (?, ?, ?, ?)");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function buscarPessoa($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from usuario where email = ?");
        if ($query->execute($array)) {
            $pessoa = $query->fetch();
            return $pessoa;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function atualizarDados($conexao, $array)
{
    try {
        $query = $conexao->prepare("update usuario set nome= ?, email = ?, imagemPerfil= ? where idUsuario = ?");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}


function deletarConta($conexao, $array)
{
    try {
        $query = $conexao->prepare("delete from usuario where idUsuario = ?");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function alterarSenha($conexao, $array)
{
    try {
        $query = $conexao->prepare("update usuario set senha = ?, reckey = null  where idUsuario = ?");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function confirmarConta($conexao, $array)
{
    try {
        $query = $conexao->prepare("update usuario set status = true where idUsuario = ?");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}

function adicionarToken($conexao, $array)
{
    try {
        $query = $conexao->prepare("update usuario set recKey  = ? where email = ?");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function selecionarHash($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from usuario where recKey = ?");
        if ($query->execute($array)) {
            $hash = $query->fetch();
            return $hash;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function listarItens($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from inventario_usuarios where idUsuario = ? and vendido = false order by preco desc");
        if ($query->execute($array)) {
            $itens = $query->fetchAll();
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}


function listarItensTrade($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from inventario_usuarios where idItem = ? and vendido = false and  idUsuario = ? order by preco desc");
        if ($query->execute($array)) {
            $itens = $query->fetch();
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function deletarItem($conexao, $array)
{
    try {
        $query = $conexao->prepare("delete from inventario_usuarios where idItem = ? and idUsuario = ?");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function selecionarTrocas($conexao, $array)
{
    try {
        $query = $conexao->prepare("select idTroca from troca where idUsuario = ?");
        if ($query->execute($array)) {
            $itens = $query->fetchAll(PDO::FETCH_ASSOC);
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function deletarTrocaItens($conexao, $array)
{
    try {
        $query = $conexao->prepare("delete from troca_itens where idTroca = ?");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function deletarTroca($conexao, $array)
{
    try {
        $query = $conexao->prepare("delete from troca where idUsuario = ?");
        $result = $query->execute($array);
        return $result;
    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}


function avaliarItensUser($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from inventario_usuarios where idItem = ? and idUsuario = ?");
        if ($query->execute($array)) {
            $itens = $query->fetch();
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}
function adicionaItemUser($conexao, $array)
{
    try {
        $query = $conexao->prepare("insert into inventario_usuarios (nomeSkin, tipo, estado, raridade, itemImg, preco, idUsuario, inspectInGame) values (?, ?, ?, ?, ?, ?, ?, ?)");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}


function adicionaItemSite($conexao, $array)
{
    try {
        $query = $conexao->prepare("insert into inventario_site (nomeSkin, tipo, estado, raridade, itemImg, preco, inspectInGame) values (?,?,?,?,?,?,?)");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}


function adicionaSaldo($conexao, $array)
{
    try {
        $query = $conexao->prepare("update usuario set valorCarteira  = valorCarteira + ? where idUsuario = ?");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function atualizaSaldo($conexao, $array)
{
    try {
        $query = $conexao->prepare("update usuario set valorCarteira  = ? where idUsuario = ?");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

//vende item
function vendeItem($conexao, $array)
{
    try {
        $query = $conexao->prepare("update inventario_usuarios set vendido = true where idItem = ? and idUsuario = ?");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function compraItem($conexao, $array)
{
    try {
        $query = $conexao->prepare("insert into inventario_usuarios (nomeSkin, tipo, estado, raridade, itemImg, preco, idUsuario) values (?,?,?,?,?,?,?)");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


//listar historico de trocas

function historicoTroca($conexao, $array)
{
    try {
        $query = $conexao->prepare("
        SELECT t.data,
        GROUP_CONCAT(iu.nomeSkin SEPARATOR ' <br> ') AS nomeSkinsUsuario,
        GROUP_CONCAT(isite.nomeSkin SEPARATOR ', ') AS nomeSkinsSite
        FROM troca t
        JOIN troca_itens ti ON t.idTroca = ti.idTroca
        LEFT JOIN inventario_usuarios iu ON ti.idItem = iu.idItem
        LEFT JOIN inventario_site isite ON ti.idItemSite = isite.idItemSite
        WHERE t.idUsuario = ?
        GROUP BY t.idTroca
        ORDER BY t.idTroca
        ");
        $result = $query->execute($array);
        $trocas = $query->fetchAll(PDO::FETCH_ASSOC);
        return $trocas;

    } catch (PDOException $e) {
        echo "Erro ao obter as trocas do usuário: " . $e->getMessage();
    }
}


function listarNumeroTrocas($conexao, $array)
{
    try {
        $query = $conexao->prepare("select count(*) from troca where idUsuario = ?");
        if ($query->execute($array)) {
            $trocas = $query->fetch();
            return $trocas;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}




//LOGICA ADM
function listarItensSite($conexao)
{
    try {
        $query = $conexao->prepare("select * from inventario_site where oculto = 0 order by preco desc");
        if ($query->execute()) {
            $itens = $query->fetchAll();
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function listarItensSiteID($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from inventario_site where idItemSite = ?");
        if ($query->execute()) {
            $itens = $query->fetch($array);
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro: ' . $e->getMessage();

    }
}

function listarItemsSiteTrade($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from inventario_site where idItemSite = ?");
        $query->execute($array);
        $result = $query->fetch();
        return $result;
    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function deletarItemSite($conexao, $array)
{

    try {
        $query = $conexao->prepare("delete from inventario_site where idItemSite = ?");
        $result = $query->execute($array);
        echo ($result);
        return $result;

    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function ocultarItemSite($conexao, $array)
{

    try {
        $query = $conexao->prepare("update inventario_site set oculto = 1 where idItemSite = ?");
        $result = $query->execute($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}


function avaliarItensSite($conexao, $array)
{
    try {
        $query = $conexao->prepare("select * from inventario_site where idItemSite = ?");
        if ($query->execute($array)) {
            $itens = $query->fetch();
            return $itens;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo 'Erro:' . $e->getMessage();
    }
}

function trocarItemSite($conexao, $array)
{
    try {
        $query = $conexao->prepare("insert into troca (idItem, idItemSite, idUsuario, tradeHash) values (?, ?, ?, ?)");
        $result = $query->execute($array);
        var_dump($array);
        return $result;

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}



?>