<?php
include_once "carrinho_helper.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["remover"])) {
        removerDoCarrinho($_POST["remover"]);
    }
    if (isset($_POST["atualizar"])) {
        atualizarQuantidade($_POST["produto_id"], $_POST["quantidade"]);
    }
}

$carrinho = $_SESSION['carrinho'] ?? [];
$total = calcularTotal();
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meu Carrinho - Loja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Meu Carrinho 🛒</h1>
            <a href="index.php" class="btn btn-view">← Continuar Comprando</a>
        </div>
    </header>

    <section class="card">
        <?php if (empty($carrinho)): ?>
            <div style="text-align: center; padding: 40px;">
                <p style="font-size: 1.2rem; color: #64748b;">Seu carrinho está vazio.</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">Voltar para a Loja</a>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Quantidade</th>
                            <th>Subtotal</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrinho as $id => $item): ?>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <img src="<?= $item['imagem'] ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                        <strong><?= htmlspecialchars($item['nome']) ?></strong>
                                    </div>
                                </td>
                                <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                                <td>
                                    <form method="POST" style="display: flex; gap: 5px; align-items: center;">
                                        <input type="hidden" name="produto_id" value="<?= $id ?>">
                                        <input type="number" name="quantidade" value="<?= $item['quantidade'] ?>" min="1" style="width: 60px; padding: 5px;">
                                        <button type="submit" name="atualizar" class="btn btn-primary" style="padding: 5px 10px;">✔</button>
                                    </form>
                                </td>
                                <td><strong>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></strong></td>
                                <td>
                                    <form method="POST">
                                        <button type="submit" name="remover" value="<?= $id ?>" class="btn btn-delete" style="padding: 5px 10px;">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 30px; display: flex; justify-content: flex-end; align-items: center; gap: 20px; border-top: 1px solid var(--border); padding-top: 20px;">
                <div style="text-align: right;">
                    <p style="color: #64748b; font-size: 0.9rem;">Total do Pedido:</p>
                    <h2 style="color: var(--primary); font-size: 2rem;">R$ <?= number_format($total, 2, ',', '.') ?></h2>
                </div>
                <div>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="finalizar_compra.php" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem; border-radius: 12px; background: var(--success);">Finalizar Compra</a>
                    <?php else: ?>
                        <div style="text-align: center;">
                            <p style="margin-bottom: 10px; font-size: 0.9rem; color: #ef4444;">Faça login para finalizar a compra</p>
                            <a href="login.php" class="btn btn-primary">Login / Cadastro</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>
