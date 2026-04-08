<?php
if(session_status() === PHP_SESSION_NONE) { session_start(); }
require_once "config/database.php";

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['id'];
$db = new Database();
$con = $db->conectar();

// Buscar todos os pedidos do usuário
$sql = "SELECT * FROM pedidos WHERE usuario_id = :usuario_id ORDER BY data_pedido DESC";
$stmt = $con->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id);
$stmt->execute();
$pedidos = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meus Pedidos - Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Meus Pedidos 📦</h1>
            <a href="index.php" class="btn btn-view">← Voltar à Loja</a>
        </div>
    </header>

    <section class="card">
        <?php if (empty($pedidos)): ?>
            <div style="text-align: center; padding: 40px;">
                <p style="font-size: 1.2rem; color: #64748b;">Você ainda não realizou nenhum pedido.</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">Ir às Compras</a>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID do Pedido</th>
                            <th>Data</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><strong>#<?= $pedido->id ?></strong></td>
                                <td><?= date('d/m/Y H:i', strtotime($pedido->data_pedido)) ?></td>
                                <td><strong>R$ <?= number_format($pedido->total, 2, ',', '.') ?></strong></td>
                                <td><span class="badge" style="background: <?= $pedido->status == 'Finalizado' ? '#dcfce7' : '#fee2e2' ?>; color: <?= $pedido->status == 'Finalizado' ? '#166534' : '#991b1b' ?>;"><?= $pedido->status ?></span></td>
                                <td>
                                    <a href="detalhes_pedido.php?id=<?= $pedido->id ?>" class="btn btn-view">Ver Itens</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>
