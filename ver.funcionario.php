<?php
session_start();
include_once "objetos/FuncionarioController.php";

if (!isset($_SESSION['usuario']) || strtolower($_SESSION['funcao']) !== 'gerente') {
    header("Location: loginfuncionario.php");
    exit();
}

$controller = new FuncionarioController();
if (isset($_GET['id'])) {
    $funcionario = $controller->localizarFuncionario($_GET['id']);
}

if (!$funcionario) {
    echo "Funcionário não encontrado.";
    exit();
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar Funcionário</title>
</head>
<body>

<h1>Detalhes do Funcionário</h1>
<a href="painelgerenciamento.php">Voltar para o Painel</a>
<hr>

<div style="margin-top: 20px;">
    <?php if(!empty($funcionario->imagem)): ?>
        <img style="max-width: 300px; border-radius: 8px;" src="uploads/<?= htmlspecialchars($funcionario->imagem) ?>" alt="Foto de Perfil">
    <?php else: ?>
        <img style="max-width: 300px; border-radius: 8px;" src="imagens/img_fail.jpg" alt="Sem Foto">
    <?php endif; ?>
</div>

<p><strong>ID:</strong> <?= htmlspecialchars($funcionario->id) ?></p>
<p><strong>Nome:</strong> <?= htmlspecialchars($funcionario->nome) ?></p>
<p><strong>CPF:</strong> <?= htmlspecialchars($funcionario->cpf) ?></p>
<p><strong>Endereço:</strong> <?= htmlspecialchars($funcionario->endereco) ?></p>
<p><strong>Telefone:</strong> <?= htmlspecialchars($funcionario->telefone) ?></p>
<p><strong>Função:</strong> <?= htmlspecialchars($funcionario->funcao) ?></p>
<p><strong>Login de Acesso:</strong> <?= htmlspecialchars($funcionario->login) ?></p>

<hr>
<div style="margin-top: 20px;">
    <a href="alterarfuncionario.php?alterar=<?= $funcionario->id ?>" style="padding: 10px 15px; background: #2c5282; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Alterar Dados</a>
    <a href="excluirfuncionario.php?excluir=<?= $funcionario->id ?>" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')" style="padding: 10px 15px; background: #e53e3e; color: white; text-decoration: none; border-radius: 5px;">Excluir Funcionário</a>
</div>

</body>
</html>
