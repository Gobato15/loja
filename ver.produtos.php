<?php
session_start();
include_once("objetos/ProdutosController.php");

$controller = new ProdutosController();

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $a = $controller->localizarProduto($_GET['id']);
}

//var_dump($a);

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalhes: <?= htmlspecialchars($a->nome) ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-detail {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }
        .detail-info p {
            margin-bottom: 1rem;
            font-size: 1.1rem;
            border-bottom: 1px solid var(--border);
            padding-bottom: 0.5rem;
        }
        .detail-info strong {
            color: var(--primary);
            width: 120px;
            display: inline-block;
        }
        @media (max-width: 768px) {
            .product-detail { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Loja de Informática</h1>
        <div class="user-info">
            <a href="index.php" class="btn btn-view">⬅️ Voltar ao Catálogo</a>
        </div>
    </header>

    <div class="card">
        <div class="product-detail">
            <div class="detail-image">
                <?php 
                    $img_src = "imagens/placeholder.png";
                    if(!empty($a->imagem) && file_exists("uploads/" . $a->imagem)) {
                        $img_src = "uploads/" . $a->imagem;
                    }
                ?>
                <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($a->nome) ?>" style="width: 100%; max-width: 400px; border-radius: 15px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
            </div>

            <div class="detail-info">
                <h2 style="color: var(--primary); margin-bottom: 1.5rem; font-size: 2rem;">#<?= $a->id ?> - <?= htmlspecialchars($a->nome) ?></h2>
                
                <p><strong>Descrição:</strong> <?= htmlspecialchars($a->descricao) ?></p>
                <p><strong>Estoque:</strong> <?= $a->quantidade ?> unidades</p>
                <p><strong>Preço:</strong> <span style="font-size: 1.5rem; color: var(--success); font-weight: 600;">R$ <?= number_format($a->preco, 2, ',', '.') ?></span></p>
                
                <?php if(isset($_SESSION['funcao']) && (strtolower($_SESSION['funcao']) === 'gerente' || strtolower($_SESSION['funcao']) === 'técnico em eletrônica')): ?>
                    <div style="margin-top: 2rem; display: flex; gap: 10px;">
                        <a href="atualizar.php?alterar=<?= $a->id ?>" class="btn btn-edit" style="flex: 1; padding: 12px;">✏️ Alterar Produto</a>
                        <a href="index.php?excluir=<?= $a->id ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')" class="btn btn-delete" style="flex: 1; padding: 12px;">🗑️ Excluir Produto</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>

