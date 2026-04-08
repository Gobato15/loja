<?php
include_once "carrinho_helper.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["remover"])) {
        removerDoCarrinho($_POST["remover"]);
    }
    if (isset($_POST["atualizar"])) {
        atualizarQuantidade($_POST["produto_id"], $_POST["quantidade"]);
    }
    if (isset($_POST["calcular_cep"])) {
        calcularFrete($_POST["cep"]);
    }
}

$carrinho = $_SESSION['carrinho'] ?? [];
$subtotal = 0;
foreach($carrinho as $item) { 
    $subtotal += (float)$item['preco'] * (int)$item['quantidade']; 
}
$frete = $_SESSION['frete'] ?? 0;
$total = $subtotal + $frete;
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
                                <td><strong>R$ <?= number_format((float)$item['preco'] * (int)$item['quantidade'], 2, ',', '.') ?></strong></td>
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

            <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: flex-start; gap: 40px; border-top: 1px solid var(--border); padding-top: 30px;">
                <div class="cep-section" style="flex: 1; max-width: 300px;">
                    <p style="font-weight: 600; margin-bottom: 10px; color: var(--primary);">Calcular Frete:</p>
                    <form method="POST" style="display: flex; gap: 10px;">
                        <input type="text" name="cep" placeholder="00000-000" value="<?= $_SESSION['cep'] ?? '' ?>" required style="flex: 1; padding: 10px;">
                        <button type="submit" name="calcular_cep" class="btn btn-view" style="background: var(--accent); color: white;">Calcular</button>
                    </form>
                    <?php if($frete > 0): ?>
                        <p style="margin-top: 10px; font-size: 0.85rem; color: #059669;">🚚 Entrega estimada para o CEP: <?= $_SESSION['cep'] ?></p>
                    <?php endif; ?>
                </div>

                <div style="flex: 1; text-align: right;">
                    <div style="margin-bottom: 15px;">
                        <p style="color: #64748b; font-size: 0.95rem;">Subtotal: <strong>R$ <?= number_format($subtotal, 2, ',', '.') ?></strong></p>
                        <p style="color: #64748b; font-size: 0.95rem;">Frete: <strong><?= $frete > 0 ? 'R$ ' . number_format($frete, 2, ',', '.') : 'A calcular' ?></strong></p>
                    </div>
                    <div style="border-top: 2px solid var(--border); padding-top: 15px;">
                        <p style="color: #64748b; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Total do Pedido:</p>
                        <h2 style="color: var(--primary); font-size: 2.5rem; font-weight: 700;">R$ <?= number_format($total, 2, ',', '.') ?></h2>
                    </div>
                </div>

                <div style="display: flex; align-items: center; justify-content: center; min-width: 250px;">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <a href="finalizar_compra.php" class="btn btn-primary" style="padding: 18px 45px; font-size: 1.2rem; border-radius: 12px; background: #059669; box-shadow: 0 4px 14px rgba(5, 150, 105, 0.4); width: 100%;">Finalizar Compra</a>
                    <?php else: ?>
                        <div style="text-align: center; background: #fee2e2; padding: 20px; border-radius: 15px; border: 1px solid #fecaca; width: 100%;">
                            <p style="margin-bottom: 15px; font-size: 0.95rem; color: #991b1b; font-weight: 600;">🔒 Faça login para comprar</p>
                            <a href="login_cliente.php" class="btn btn-primary" style="width: 100%;">Login / Cadastro</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>
