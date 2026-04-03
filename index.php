<?php
session_start();

// Barreira de autenticação: se não houver usuário logado, redireciona para login.php
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
include_once"objetos/ProdutosController.php";

$controller = new ProdutosController();
$produtos = $controller->index();
global $produtos;
$a = null;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["pesquisar"])){
        $valor = $_POST["pesquisar"];
        $tipo = $_POST["tipo"];
        $a = $controller->pesquisaProduto($_POST["pesquisar"], $_POST["tipo"]);
            }


    }

if($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["excluir"])){
        $funcao_user = strtolower($_SESSION['funcao'] ?? '');
        if ($funcao_user === 'gerente' || $funcao_user === 'técnico em eletrônica') {
            $a = $controller->excluirProduto($_GET["excluir"]);
        } else {
            echo "<script>alert('Ação restrita apenas para gerentes e técnicos.');</script>";
        }
    }
}



?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja de Informática - Home</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            background: #e2e8f0;
            color: #1e293b;
            font-weight: 600;
        }
        .nav-links {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .nav-links a {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .nav-links a:hover {
            text-decoration: underline;
        }
        .section-title {
            margin-bottom: 1.5rem;
            color: var(--primary);
            font-weight: 600;
            border-left: 4px solid var(--accent);
            padding-left: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>Loja de Informática</h1>
        
        <?php if(isset($_SESSION['usuario'])): ?>
            <div class="user-info">
                <div>
                    👤 Usuário: <strong><?= htmlspecialchars($_SESSION['nome_usuario']); ?></strong> 
                    | Cargo: <span class="badge"><?= htmlspecialchars(ucfirst($_SESSION['funcao'])); ?></span>
                </div>
                <a href="logout.php" class="btn btn-view" style="padding: 5px 12px;">Sair (Logout)</a>
            </div>
        <?php endif; ?>
    </header>

    <div class="nav-links">
        <?php 
        $funcao = strtolower($_SESSION['funcao'] ?? '');
        if($funcao === 'gerente' || $funcao === 'técnico em eletrônica'): 
        ?>
            <a href="cadastro.php">➕ Cadastrar Produto</a>
            <?php if($funcao === 'gerente'): ?>
                <a href="painelgerenciamento.php">⚙️ Gerenciar Funcionários</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <section class="card">
        <h3 class="section-title">Pesquisar Produto</h3>
        <form method="POST" action="index.php" class="search-box">
            <input type="text" name="pesquisar" placeholder="ID ou Nome do produto..." required style="flex: 1; min-width: 200px;">
            <select name="tipo">
                <option value="id">Buscar por ID</option>
                <option value="nome" selected>Buscar por Nome</option>
            </select>
            <button class="btn btn-primary">Pesquisar</button>
        </form>

        <?php if($a) : ?>
            <div class="table-container" style="margin-top: 20px; border: 2px solid var(--accent);">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($a as $produto) : ?>
                            <tr>
                                <td><strong>#<?= $produto->id; ?></strong></td>
                                <td><?= $produto->nome; ?></td>
                                <td>
                                    <div class="btn-group" style="justify-content: center;">
                                        <a href="atualizar.php?alterar=<?= $produto->id ?>" class="btn btn-edit">Alterar</a>
                                        <a href="index.php?excluir=<?= $produto->id ?>" onclick="return confirm('Excluir este produto?')" class="btn btn-delete">Excluir</a>
                                        <a href="ver.produtos.php?id=<?= $produto->id ?>" class="btn btn-view">Ver</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p style="text-align: center; margin-top: 10px;"><a href="index.php" style="color: var(--accent);">Limpar pesquisa</a></p>
        <?php endif; ?>
    </section>

    <section class="card">
        <h2 class="section-title">Catálogo Completo</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Info</th>
                        <th>Estoque</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($produtos) : ?>
                        <?php foreach($produtos as $produto) : ?>
                            <tr>
                                <td><strong>#<?= $produto->id;?></strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                <?php 
                                    $img_src = "imagens/img_fail.jpg";
                                    if(!empty($produto->imagem) && file_exists("uploads/" . $produto->imagem)) {
                                        $img_src = "uploads/" . $produto->imagem;
                                    }
                                ?>
                                <img class="product-img" src="<?= $img_src ?>">
                                        <strong><?= $produto->nome;?></strong>
                                    </div>
                                </td>
                                <td><small style="color: #64748b;"><?= mb_strimwidth($produto->descricao, 0, 40, "..."); ?></small></td>
                                <td><?= $produto->quantidade;?> un.</td>
                                <td><strong>R$ <?= number_format($produto->preco, 2, ',', '.');?></strong></td>
                                <td>
                                    <div class="btn-group">
                                        <?php if($funcao === 'gerente' || $funcao === 'técnico em eletrônica'): ?>
                                            <a href="atualizar.php?alterar=<?= $produto->id ?>" class="btn btn-edit" title="Editar">Alterar</a>
                                            <a href="index.php?excluir=<?= $produto->id ?>" onclick="return confirm('Deseja excluir este produto?')" class="btn btn-delete" title="Excluir">Excluir</a>
                                        <?php endif; ?>
                                        <a href="ver.produtos.php?id=<?= $produto->id ?>" class="btn btn-view">Ver Detalhes</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; padding: 40px;">Nenhum produto encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>

