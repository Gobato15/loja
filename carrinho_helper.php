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
            'id' => (int)$id,
            'nome' => $nome,
            'preco' => (float)$preco,
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
        $qtd = (int)$qtd;
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
    $subtotal = 0;
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }
    }
    $frete = $_SESSION['frete'] ?? 0;
    return $subtotal + $frete;
}

function calcularFrete($cep) {
    // Simulação de cálculo de frete
    $digito = substr($cep, 0, 1);
    switch ($digito) {
        case '0':
        case '1':
            $valor = 15.00; // SP/Grande SP
            break;
        case '2':
            $valor = 25.00; // RJ/ES
            break;
        case '3':
            $valor = 22.00; // MG
            break;
        default:
            $valor = 45.00; // Outras regiões
            break;
    }
    $_SESSION['frete'] = $valor;
    $_SESSION['cep'] = $cep;
    return $valor;
}
?>
