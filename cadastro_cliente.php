<?php
include_once "objetos/ClienteController.php";

$erro = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $controller = new ClienteController();
    $erro = $controller->cadastrar($_POST);
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Cliente - Loja</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="card" style="max-width: 500px; width: 100%;">
    <h1 style="text-align: center; color: var(--primary); margin-bottom: 2rem;">Criar Minha Conta</h1>
    
    <?php if($erro): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
            <?= $erro ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nome Completo</label>
            <input type="text" name="nome" required style="width: 100%;">
        </div>
        
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">E-mail</label>
            <input type="email" name="email" required style="width: 100%;">
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 1rem;">
            <div style="flex: 1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">CPF</label>
                <input type="text" name="cpf" required style="width: 100%;" placeholder="000.000.000-00">
            </div>
            <div style="flex: 1;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600;">Telefone</label>
                <input type="text" name="telefone" required style="width: 100%;" placeholder="(00) 00000-0000">
            </div>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Endereço de Entrega</label>
            <input type="text" name="endereco" required style="width: 100%;" placeholder="Rua, número, bairro, cidade...">
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Senha</label>
            <input type="password" name="senha" required style="width: 100%;">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem;">Criar Conta e Entrar</button>
    </form>

    <p style="text-align: center; margin-top: 1.5rem; font-size: 0.9rem;">
        Já tem uma conta? <a href="login_cliente.php" style="color: var(--accent); font-weight: 600;">Fazer Login</a>
    </p>
    <a href="index.php" style="display: block; text-align: center; margin-top: 10px; color: #64748b; text-decoration: none;">← Voltar à Loja</a>
</div>

</body>
</html>
