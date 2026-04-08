<?php
if(session_status() === PHP_SESSION_NONE) { session_start(); }

function adicionarAoCarrinho($id, $nome, $preco, $imagem) {
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]['quantidade']++;
    } else {
        $_SESSION['carrinho'][$id] = [
            'id' => $id,
            'nome' => $nome,
            'preco' => $preco,
            'imagem' => $imagem,
            'quantidade' => 1
        ];
    }
}

function removerDoCarrinho($id) {
    if (isset($_SESSION['carrinho'][$id])) {
        unset($_SESSION['carrinho'][$id]);
    }
}

function atualizarQuantidade($id, $qtd) {
    if (isset($_SESSION['carrinho'][$id])) {
        if ($qtd > 0) {
            $_SESSION['carrinho'][$id]['quantidade'] = $qtd;
        } else {
            removerDoCarrinho($id);
        }
    }
}

function limparCarrinho() {
    $_SESSION['carrinho'] = [];
}

function calcularTotal() {
    $total = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
    }
    return $total;
}
?>
