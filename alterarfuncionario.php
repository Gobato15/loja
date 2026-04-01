<?php
session_start();
if (!isset($_SESSION['usuario']) || strtolower($_SESSION['funcao']) !== 'gerente') {
    header("Location: loginfuncionario.php");
    exit();
}
include_once("objetos/FuncionarioController.php");

$controller = new FuncionarioController();

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["alterar"])) {
    $a = $controller->localizarFuncionario($_GET["alterar"]);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["funcionario"])) {
    $a = $controller->atualizarFuncionario($_POST["funcionario"], $_FILES["funcionario"]);
} else {
    header("Location: index.php");
    exit();
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alteração de Funcionário</title>
</head>
<body>
<h1>Alteração de Funcionário</h1>
<a href="painelgerenciamento.php">Voltar</a>

<form action="alterarfuncionario.php" method="post" enctype="multipart/form-data">
    <!-- ID escondido importante para a atualização -->
    <input type="text" name="funcionario[id]" value="<?= $a->id ?>" hidden>
    
    <label>Nome</label>
    <input type="text" name="funcionario[nome]" value="<?= $a->nome ?>" required>
    <br><br>

    <label>CPF</label>
    <input type="text" name="funcionario[cpf]" value="<?= $a->cpf ?>" required>
    <br><br>

    <label>Endereço</label>
    <input type="text" name="funcionario[endereco]" value="<?= $a->endereco ?>">
    <br><br>

    <label>Telefone</label>
    <input type="text" name="funcionario[telefone]" value="<?= $a->telefone ?>">
    <br><br>

    <label>Função</label>
    <input type="text" name="funcionario[funcao]" value="<?= $a->funcao ?>">
    <br><br>

    <label>Login</label>
    <input type="text" name="funcionario[login]" value="<?= $a->login ?>" required>
    <br><br>

    <label>Senha</label>
    <input type="password" name="funcionario[senha]" value="<?= $a->senha ?>" required>
    <br><br>

    <label for="imagem">Atualizar Foto (Opcional)</label>
    <input type="file" name="funcionario[fileToUpload]" id="imagem">
    <br><br>

    <button name="atualizar">Atualizar</button>
</form>

</body>
</html>
