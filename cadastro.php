<?php
session_start();
$funcao_atual = strtolower($_SESSION['funcao'] ?? '');
if (!isset($_SESSION['usuario']) || ($funcao_atual !== 'gerente' && $funcao_atual !== 'técnico em eletrônica')) {
    header("Location: loginfuncionario.php");
    exit();
}
include_once("objetos/ProdutosController.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controller = new produtosController();

    if(isset($_POST['cadastrar'])){
        $a = $controller->cadastrarProduto($_POST["produto"], $_FILES["produto"]);
    }
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Produto</title>
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
        .form-group input {
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
        <h2 style="margin-bottom: 1.5rem; color: var(--primary);">➕ Cadastrar Novo Produto</h2>
        
        <form action="cadastro.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nome do Produto</label>
                <input type="text" name="produto[nome]" placeholder="Ex: Monitor Gamer 24\"" required>
            </div>

            <div class="form-group">
                <label>Descrição</label>
                <input type="text" name="produto[descricao]" placeholder="Breve descrição do produto...">
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="form-group" style="flex: 1;">
                    <label>Quantidade</label>
                    <input type="number" name="produto[quantidade]" value="1" min="1" required>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label>Preço (R$)</label>
                    <input type="text" name="produto[preco]" placeholder="0.00" required>
                </div>
            </div>

            <div class="form-group">
                <label>Imagem do Produto</label>
                <input type="file" name="produto[fileToUpload]" id="fileToUpload">
            </div>

            <div style="margin-top: 2rem;">
                <button name="cadastrar" class="btn btn-primary" style="width: 100%; padding: 12px;">🚀 Finalizar Cadastro</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
