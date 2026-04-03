<?php
session_start();
$funcao_atual = strtolower($_SESSION['funcao'] ?? '');
if (!isset($_SESSION['usuario']) || ($funcao_atual !== 'gerente' && $funcao_atual !== 'técnico em eletrônica')) {
    header("Location: loginfuncionario.php");
    exit();
}
include_once("objetos/ProdutosController.php");

$controller = new produtosController();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["alterar"])) {
    $a = $controller->localizarProduto($_GET["alterar"]);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["produto"])) {
    $a = $controller->atualizarProduto($_POST["produto"], $_FILES['produto']);
} else {
    header("Location: index.php");
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atualização de Produto</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .form-group input, .form-group textarea {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Gerenciamento de Produtos</h1>
        <div class="user-info">
            <a href="index.php" class="btn btn-view">⬅️ Voltar ao Painel</a>
        </div>
    </header>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 style="margin-bottom: 1.5rem; color: var(--primary);">✏️ Atualizar Produto</h2>
        
        <form action="atualizar.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="produto[id]" value="<?= $a->id ?>">

            <div class="form-group">
                <label>Nome do Produto</label>
                <input type="text" name="produto[nome]" value="<?= htmlspecialchars(trim($a->nome)) ?>" required>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="produto[descricao]" value="<?= htmlspecialchars(trim($a->descricao)) ?>">
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Quantidade</label>
                    <input type="number" name="produto[quantidade]" value="<?= (int)$a->quantidade ?>" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Preço (R$)</label>
                    <input type="text" name="produto[preco]" value="<?= $a->preco ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Imagem do Produto</label>
                <div style="margin-bottom: 10px;">
                    <?php if(!empty($a->imagem) && file_exists("uploads/".$a->imagem)): ?>
                        <div style="margin-bottom: 10px;">
                            <p style="font-size: 0.8rem; margin-bottom: 5px;">Imagem Atual:</p>
                            <img src="uploads/<?= $a->imagem ?>" style="max-width: 150px; border-radius: 8px; border: 1px solid var(--border);">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="produto[fileToUpload]" id="fileToUpload">
                </div>
            </div>

            <div style="margin-top: 2rem;">
                <button name="atualizar" class="btn btn-primary" style="width: 100%; padding: 12px;">✅ Atualizar Informações</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>