<?php
session_start();

include_once"objetos/ProdutosController.php";
include_once"carrinho_helper.php";

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
    
    if(isset($_POST["add_to_cart"])){
        adicionarAoCarrinho($_POST["id"], $_POST["nome"], $_POST["preco"], $_POST["imagem"]);
        header("Location: carrinho.php");
        exit();
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
    <header style="padding: 1rem 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
            <h1 style="margin-bottom: 0; font-size: 1.6rem;">Loja de Informática</h1>
            
            <div style="display: flex; align-items: center; gap: 20px;">
                <?php if(isset($_SESSION['usuario'])): ?>
                    <div style="display: flex; gap: 15px; align-items: center; background: #f8fafc; padding: 8px 15px; border-radius: 50px; border: 1px solid var(--border);">
                        <?php if(!empty($_SESSION['imagem_usuario']) && file_exists("uploads/" . $_SESSION['imagem_usuario'])): ?>
                            <img src="uploads/<?= $_SESSION['imagem_usuario'] ?>" style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                        <?php else: ?>
                            <span style="font-size: 1.2rem;">👤</span>
                        <?php endif; ?>
                        
                        <div style="font-size: 0.9rem;">
                            <strong><?= htmlspecialchars($_SESSION['nome_usuario']); ?></strong>
                        </div>
                        <a href="logout.php" title="Sair" style="text-decoration: none; font-size: 0.8rem; color: #64748b;">🚪</a>
                    </div>
                <?php else: ?>
                    <div class="btn-group">
                        <a href="login_cliente.php" class="btn btn-primary" style="padding: 8px 20px;">Login</a>
                        <a href="loginfuncionario.php" class="btn btn-view" style="padding: 8px 12px; font-size: 0.75rem;">Staff</a>
                    </div>
                <?php endif; ?>
                <?php 
                    $cart_count = 0;
                    if(isset($_SESSION['carrinho'])) {
                        foreach($_SESSION['carrinho'] as $item) { $cart_count += (int)$item['quantidade']; }
                    }
                ?>
                <a href="carrinho.php" class="header-cart-btn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                        <path d="M3 6h18"></path>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span style="margin-left: 2px;">Meu Carrinho</span>
                    <?php if($cart_count > 0): ?>
                        <span class="cart-badge"><?= $cart_count ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </header>

    <!-- Floating Cart for high visibility -->
    <a href="carrinho.php" class="cart-floating">
        🛒
        <?php if($cart_count > 0): ?>
            <span class="badge"><?= $cart_count ?></span>
        <?php endif; ?>
    </a>

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

    <section>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 class="section-title" style="margin-bottom: 0;">Nossos Produtos</h2>
            <div class="search-box" style="margin-bottom: 0;">
                <form method="POST" action="index.php" style="display: flex; gap: 10px;">
                    <input type="text" name="pesquisar" placeholder="Buscar produto..." required style="padding: 8px 15px;">
                    <input type="hidden" name="tipo" value="nome">
                    <button class="btn btn-primary" style="padding: 8px 16px;">🔍</button>
                </form>
            </div>
        </div>

        <?php if($a || $produtos) : 
            $display_list = $a ? $a : $produtos;
        ?>
            <div class="catalog-grid">
                <?php foreach($display_list as $produto) : ?>
                    <div class="product-card">
                        <?php 
                            $img_src = "imagens/placeholder.png";
                            if(!empty($produto->imagem) && file_exists("uploads/" . $produto->imagem)) {
                                $img_src = "uploads/" . $produto->imagem;
                            }
                        ?>
                        
                        <div class="product-card-img-container">
                            <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($produto->nome); ?>" class="product-card-img">
                        </div>

                        <?php if($produto->quantidade > 0): ?>
                            <span class="badge-stock">Em estoque (<?= $produto->quantidade ?>)</span>
                        <?php else: ?>
                            <span class="badge-stock" style="color: var(--danger);">Esgotado</span>
                        <?php endif; ?>

                        <?php if($funcao === 'gerente' || $funcao === 'técnico em eletrônica'): ?>
                            <div class="admin-actions">
                                <a href="atualizar.php?alterar=<?= $produto->id ?>" class="btn btn-edit" style="padding: 5px 10px; font-size: 0.7rem;" title="Editar">✏️</a>
                                <a href="index.php?excluir=<?= $produto->id ?>" onclick="return confirm('Excluir este produto?')" class="btn btn-delete" style="padding: 5px 10px; font-size: 0.7rem;" title="Excluir">🗑️</a>
                            </div>
                        <?php endif; ?>

                        <div class="product-card-content">
                            <h3 class="product-card-title"><?= htmlspecialchars($produto->nome); ?></h3>
                            <p class="product-card-description"><?= htmlspecialchars($produto->descricao); ?></p>
                            
                            <div class="product-card-footer">
                                <div class="product-card-price">
                                    <small>R$</small> <?= number_format($produto->preco, 2, ',', '.'); ?>
                                </div>
                                <form method="POST" action="index.php">
                                    <input type="hidden" name="id" value="<?= $produto->id ?>">
                                    <input type="hidden" name="nome" value="<?= $produto->nome ?>">
                                    <input type="hidden" name="preco" value="<?= $produto->preco ?>">
                                    <input type="hidden" name="imagem" value="<?= $img_src ?>">
                                    <button type="submit" name="add_to_cart" class="btn-buy" style="border: none; cursor: pointer;">Comprar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if($a): ?>
                <p style="text-align: center; margin-top: 30px;"><a href="index.php" class="btn btn-view">Ver Catálogo Completo</a></p>
            <?php endif; ?>

        <?php else: ?>
            <div class="card" style="text-align: center; padding: 60px;">
                <p style="font-size: 1.2rem; color: #64748b;">Nenhum produto encontrado.</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 20px;">Limpar Pesquisa</a>
            </div>
        <?php endif; ?>
    </section>
</div>

</body>
</html>

