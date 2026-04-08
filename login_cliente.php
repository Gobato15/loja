<?php
include_once "objetos/ClienteController.php";

$erro = null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $controller = new ClienteController();
    $erro = $controller->login($_POST['email'], $_POST['senha']);
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Cliente - Loja</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="card" style="max-width: 400px; width: 100%;">
    <h1 style="text-align: center; color: var(--primary); margin-bottom: 2rem;">Login Cliente</h1>
    
    <?php if(isset($_GET['msg']) && $_GET['msg'] === 'sucesso'): ?>
        <div style="background: #dcfce7; color: #166534; padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
            Conta criada com sucesso! Faça login abaixo.
        </div>
    <?php endif; ?>

    <?php if($erro): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 8px; margin-bottom: 1rem; text-align: center;">
            <?= $erro ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">E-mail</label>
            <input type="email" name="email" required style="width: 100%;" placeholder="seu@email.com">
        </div>
        
        <div style="margin-bottom: 2rem;">
            <label style="display: block; margin-bottom: 5px; font-weight: 600;">Senha</label>
            <input type="password" name="senha" required style="width: 100%;" placeholder="Sua senha">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px; font-size: 1.1rem;">Entrar</button>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        <p style="font-size: 0.9rem; color: #64748b;">Ainda não tem uma conta?</p>
        <a href="cadastro_cliente.php" class="btn btn-view" style="width: 100%; margin-top: 10px;">Cadastrar-se Agora</a>
    </div>

    <a href="index.php" style="display: block; text-align: center; margin-top: 1.5rem; color: #64748b; text-decoration: none;">← Voltar à Loja</a>
    <a href="loginfuncionario.php" style="display: block; text-align: center; margin-top: 10px; color: var(--accent); text-decoration: none; font-size: 0.8rem;">Acesso Administrativo</a>
</div>

</body>
</html>
