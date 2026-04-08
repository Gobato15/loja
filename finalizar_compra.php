<?php
include_once "carrinho_helper.php";
require_once "config/database.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$carrinho = $_SESSION['carrinho'] ?? [];
if (empty($carrinho)) {
    header("Location: index.php");
    exit();
}

$total = calcularTotal();
$usuario_id = $_SESSION['id'];

$db = new Database();
$con = $db->conectar();

try {
    $con->beginTransaction();

    // 1. Inserir Pedido
    $sql_pedido = "INSERT INTO pedidos (usuario_id, total, status) VALUES (:usuario_id, :total, 'Finalizado')";
    $stmt = $con->prepare($sql_pedido);
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':total', $total);
    $stmt->execute();
    
    $pedido_id = $con->lastInsertId();

    // 2. Inserir Itens do Pedido
    $sql_item = "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, preco_unitario) 
                 VALUES (:pedido_id, :produto_id, :quantidade, :preco_unitario)";
    $stmt_item = $con->prepare($sql_item);

    foreach ($carrinho as $id => $item) {
        $stmt_item->bindParam(':pedido_id', $pedido_id);
        $stmt_item->bindParam(':produto_id', $item['id']);
        $stmt_item->bindParam(':quantidade', $item['quantidade']);
        $stmt_item->bindParam(':preco_unitario', $item['preco']);
        $stmt_item->execute();
        
        // 3. Atualizar Estoque
        $sql_estoque = "UPDATE produtos SET quantidade = quantidade - :quantidade WHERE id = :id";
        $stmt_estoque = $con->prepare($sql_estoque);
        $stmt_estoque->bindParam(':quantidade', $item['quantidade']);
        $stmt_estoque->bindParam(':id', $item['id']);
        $stmt_estoque->execute();
    }

    $con->commit();
    
    // Limpar carrinho
    limparCarrinho();
    
    $sucesso = true;
} catch (Exception $e) {
    $con->rollBack();
    $erro = "Erro ao processar pedido: " . $e->getMessage();
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pedido Finalizado - Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container" style="max-width: 600px; padding-top: 100px; text-align: center;">
    <?php if (isset($sucesso)): ?>
        <div class="card" style="border-top: 5px solid var(--success);">
            <div style="font-size: 4rem; margin-bottom: 20px;">✅</div>
            <h1 style="color: var(--primary);">Pedido Finalizado!</h1>
            <p style="color: #64748b; margin: 20px 0;">Obrigado pela sua compra. Seu pedido foi registrado com sucesso.</p>
            <div class="btn-group" style="justify-content: center; margin-top: 30px;">
                <a href="index.php" class="btn btn-primary">Voltar para a Loja</a>
                <a href="meus_pedidos.php" class="btn btn-view">Ver Meus Pedidos</a>
            </div>
        </div>
    <?php else: ?>
        <div class="card" style="border-top: 5px solid var(--danger);">
            <div style="font-size: 4rem; margin-bottom: 20px;">❌</div>
            <h1 style="color: var(--danger);">Ops! Algo deu errado.</h1>
            <p style="color: #64748b; margin: 20px 0;"><?= $erro ?></p>
            <a href="carrinho.php" class="btn btn-primary">Voltar ao Carrinho</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
