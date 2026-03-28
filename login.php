<?php
include "objetos/ProdutosController.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST["login"]) && isset($_POST["senha"])){
        $controller = new ProdutosController();
        $controller->login($_POST["login"], $_POST["senha"]);
    }
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
</head>
<body>

<form method="POST"action="login.php">
    <label for="login">Login</label>
    <input type="text"id="login"name="login">
    <label for="senha">Senha</label>
    <input type="password"id="senha"name="senha">
    <button>Entrar</button>
</form>

</body>
</html>
