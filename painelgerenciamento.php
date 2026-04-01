<?php
session_start();

// ====== BARREIRA DE SEGURANÇA ======
// Verifica se a sessão existe e se a função (cargo) do usuário é de "gerente".
// Se não for um gerente, é redirecionado de volta para o login.
if (!isset($_SESSION['usuario']) || strtolower($_SESSION['funcao']) !== 'gerente') {
    header("Location: loginfuncionario.php");
    exit();
}

include_once "objetos/FuncionarioController.php";
$controller = new FuncionarioController();
$funcionarios = $controller->index();
$a = null;

// Lógica de pesquisa replicando o index original
if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["pesquisar"])){
        $a = $controller->pesquisaFuncionario($_POST["pesquisar"], $_POST["tipo"]);
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerenciamento de Funcionários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <header>
        <h1>Painel do Gerente</h1>
        <div class="user-info">
            <div>
                <span style="color: var(--success);">🟢 Logado como:</span> <strong><?= htmlspecialchars($_SESSION['nome_usuario']); ?></strong> 
            </div>
            <div class="btn-group">
                <a href="index.php" class="btn btn-view">Vender Produtos</a>
                <a href="logout.php" class="btn btn-delete" style="opacity: 0.8;">Sair</a>
            </div>
        </div>
    </header>

    <div style="margin-bottom: 2rem;">
        <a href="cadastrarfuncionario.php" class="btn btn-primary" style="padding: 12px 24px;">➕ Cadastrar Novo Funcionário</a>
    </div>

    <section class="card">
        <h3 style="margin-bottom: 1.2rem; color: var(--primary);">Pesquisa Rápida</h3>
        <form method="POST" action="painelgerenciamento.php" class="search-box">
            <input type="text" name="pesquisar" placeholder="Digite para buscar..." style="flex: 1;">
            <select name="tipo">
                <option value="id">Buscar por ID</option>
                <option value="nome" selected>Buscar por Nome</option>
                <option value="cpf">Buscar por CPF</option>
            </select>
            <button class="btn btn-primary">Pesquisar</button>
        </form>

        <?php if($a) : ?>
            <div class="table-container" style="border: 2px solid var(--accent); margin-top: 15px;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Cargo</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($a as $func) : ?>
                            <tr>
                                <td><strong>#<?= $func->id; ?></strong></td>
                                <td><?= $func->nome; ?></td>
                                <td><?= $func->funcao; ?></td>
                                <td>
                                    <div class="btn-group" style="justify-content: center;">
                                        <a href="alterarfuncionario.php?alterar=<?= $func->id ?>" class="btn btn-edit">Alterar</a>
                                        <a href="excluirfuncionario.php?excluir=<?= $func->id ?>" class="btn btn-delete">Excluir</a>
                                        <a href="ver.funcionario.php?id=<?= $func->id ?>" class="btn btn-view">Ver</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <section class="card">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Listagem Geral de Funcionários</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Colaborador</th>
                        <th>Contato</th>
                        <th>Acesso</th>
                        <th style="text-align: center;">Gerenciar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($funcionarios) : ?>
                        <?php foreach($funcionarios as $func) : ?>
                            <tr>
                                <td><strong>#<?= $func->id; ?></strong></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if(!empty($func->imagem)): ?>
                                            <img style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover;" src="uploads/<?= htmlspecialchars($func->imagem); ?>">
                                        <?php else: ?>
                                            <img style="width: 45px; height: 45px; border-radius: 50%;" src="imagens/img_fail.jpg">
                                        <?php endif; ?>
                                        <div>
                                            <div style="font-weight: 600;"><?= $func->nome; ?></div>
                                            <small style="color: #64748b;"><?= $func->funcao; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">
                                        📞 <?= $func->telefone; ?><br>
                                        📍 <?= mb_strimwidth($func->endereco, 0, 30, "..."); ?>
                                    </div>
                                </td>
                                <td><span class="btn-view" style="font-size: 0.75rem; padding: 2px 6px; border-radius: 4px;"><?= $func->login; ?></span></td>
                                <td>
                                    <div class="btn-group" style="justify-content: center;">
                                        <a href="alterarfuncionario.php?alterar=<?= $func->id ?>" class="btn btn-edit">Alterar</a>
                                        <a href="excluirfuncionario.php?excluir=<?= $func->id ?>" class="btn btn-delete" onclick="return confirm('Deseja excluir este colaborador?')">Excluir</a>
                                        <a href="ver.funcionario.php?id=<?= $func->id ?>" class="btn btn-view">Ver</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

</body>
</html>
