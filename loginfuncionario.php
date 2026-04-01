<?php
ob_start();
if(session_status() === PHP_SESSION_NONE) { session_start(); }
include "objetos/FuncionarioController.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST["login"]) && isset($_POST["senha"])){
        $controller = new FuncionarioController();
        // Assim como no padrão do ProdutosController do sistema, faz a chamada para o método de login 
        // Lembre-se que você precisará criar o método login() dentro de FuncionarioController.php e do funcionario.php!
        $controller->login($_POST["login"], $_POST["senha"]);
    } else {
        echo "<script>alert('Preencha login e senha!');</script>";
    }
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Funcionário</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap');
        
        :root {
            --primary: #1a365d;
            --secondary: #2c5282;
            --accent: #4299e1;
            --bg: #f7fafc;
            --white: #ffffff;
            --text: #2d3748;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: var(--text);
        }

        .login-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h1 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--secondary);
        }

        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            box-sizing: border-box;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }

        button {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #718096;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

<div class="login-card">
    <h1>Acesso Restrito</h1>
    <form method="POST" action="loginfuncionario.php">
        <div class="form-group">
            <label for="login">Login / Usuário</label>
            <input type="text" id="login" name="login" placeholder="Digite seu login" required>
        </div>
        
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
        </div>
        
        <button type="submit">Entrar no Sistema</button>
    </form>
    <a href="index.php" class="back-link">← Voltar para a Loja</a>
</div>

</body>
</html>
