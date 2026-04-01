<?php
session_start();
if (!isset($_SESSION['usuario']) || strtolower($_SESSION['funcao']) !== 'gerente') {
    header("Location: loginfuncionario.php");
    exit();
}
include_once("objetos/FuncionarioController.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controller = new FuncionarioController();

    if(isset($_POST['cadastrar'])){
        $controller->cadastrarFuncionario($_POST["funcionario"], $_FILES["funcionario"]);
    }
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Funcionário</title>
</head>
<body>
<h1>Cadastro de Funcionário</h1>
<a href="painelgerenciamento.php">Voltar</a>

<form action="cadastrarfuncionario.php" method="post" enctype="multipart/form-data">
    <label>Nome</label>
    <input type="text" name="funcionario[nome]" required>
    <br><br>

    <label>CPF</label>
    <input type="text" name="funcionario[cpf]" required>
    <br><br>

    <label>Endereço</label>
    <input type="text" name="funcionario[endereco]">
    <br><br>

    <label>Telefone</label>
    <input type="text" name="funcionario[telefone]">
    <br><br>

    <label>Função</label>
    <input type="text" name="funcionario[funcao]">
    <br><br>

    <label>Login</label>
    <input type="text" name="funcionario[login]" required>
    <br><br>

    <label>Senha</label>
    <input type="password" name="funcionario[senha]" required>
    <br><br>

    <label for="imagem">Foto de Perfil (Opcional)</label>
    <input type="file" name="funcionario[fileToUpload]" id="imagem">
    <br><br>

    <button name="cadastrar">Cadastrar</button>
</form>

</body>
</html>
