<?php
if(session_status() === PHP_SESSION_NONE) { session_start(); }
require_once "config/database.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$pedido_id = $_GET['id'] ?? 0;
$usuario_id = $_SESSION['id'];
$db = new Database();
$con = $db->conectar();

// Verificar se o pedido pertence ao usuário
$sql_pedido = "SELECT * FROM pedidos WHERE id = :id AND usuario_id = :usuario_id";
$stmt = $con->prepare($sql_pedido);
$stmt->bindParam(':id', $pedido_id);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$pedido = $stmt->fetch(PDO::FETCH_OBJ);

if (!$pedido) {
    header("Location: meus_pedidos.php");
    exit();
}

// Buscar itens do pedido
$sql_itens = "SELECT ip.*, p.nome, p.imagem 
              FROM itens_pedido ip 
              JOIN produtos p ON ip.produto_id = p.id 
              WHERE ip.pedido_id = :pedido_id";
$stmt_itens = $con->prepare($sql_itens);
$stmt_itens->bindParam(':pedido_id', $pedido_id);
$stmt_itens->execute();
$itens = $stmt_itens->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes do Pedido #<?= $pedido_id ?> - Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Itens do Pedido #<?= $pedido_id ?></h1>
            <a href="meus_pedidos.php" class="btn btn-view">← Voltar aos Meus Pedidos</a>
        </div>
    </header>

    <section class="card">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço Unit.</th>
                        <th>Qtd</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <?php 
                                        $img = "imagens/img_fail.jpg";
                                        if(!empty($item->imagem) && file_exists("uploads/" . $item->imagem)) { $img = "uploads/" . $item->imagem; }
                                    ?>
                                    <img src="<?= $img ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">
                                    <?= htmlspecialchars($item->nome) ?>
                                </div>
                            </td>
                            <td>R$ <?= number_format($item->preco_unitario, 2, ',', '.') ?></td>
                            <td><?= $item->quantidade ?></td>
                            <td><strong>R$ <?= number_format($item->preco_unitario * $item->quantidade, 2, ',', '.') ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc;">
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong style="color: var(--primary); font-size: 1.2rem;">R$ <?= number_format($pedido->total, 2, ',', '.') ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>

</body>
</html>
