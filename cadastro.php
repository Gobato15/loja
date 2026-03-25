<?php
include_once("objetos/ProdutosController.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $controller = new produtosController();

    if(isset($_POST['cadastrar'])){
        $a = $controller->cadastrarProduto($_POST["produto"], $_FILES["produto"]);
    }
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Produto</title>
</head>
<body>
<h1>Cadastro de Produto</h1>
<a href="index.php">Voltar</a>

<form action="cadastro.php" method="post" enctype="multipart/form-data">
    <label>Nome</label>
    <input type="text" name="produto[nome]">


    <label>Descrição</label>
    <input type="text" name="produto[descricao]">


    <label>Quantidade</label>
    <input type="text" name="produto[quantidade]">


    <label>Preço</label>
    <input type="text" name="produto[preco]">

    <label for="fileToUpload">Selecionar Foto</label>
    <input type="file"name="produto[fileToUpload]"id="fileToUpload"><br><br>

    <button name="cadastrar">Cadastrar</button>
</form>

</body>
</html>
