<?php
include_once"objetos/ProdutosController.php";

$controller = new ProdutosController();
$produtos = $controller->index();
global $produtos;
$a = null;

if($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["pesquisar"])){
        $valor = $_POST["pesquisar"];
        $tipo = $_POST["tipo"];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            if(isset($_POST["pesquisar"])){
                $a = $controller->pesquisaProduto($_POST["pesquisar"], $_POST["tipo"]);
            }

        }

    }
}

if($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["excluir"])){
        $a = $controller->excluirProduto($_GET["excluir"]);
    }
}


?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja</title>
    <style>
        /* Estilização da tabela  */
        table,tr,td{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

<h1>Loja de Informática</h1>
<h2>Produtos</h2>
<a href="cadastro.php">Cadastrar Produto</a>

<h3>Pesquisar Produto</h3>
<form method="POST" action="index.php">
    <label>ID</label>
    <input type="text" name="pesquisar">
    <select name="tipo">
        <option value=id>ID</option>
        <option value="nome">Nome</option>
    </select>
    <button>Pesquisar</button>
</form>

<table>
    <tr>
        <td>ID</td>
        <td>Nome</td>
    </tr>
    <?php if($a) : ?>
        <?php foreach($a as $produto) : ?>
            <tr>
                <td><?= $produto->id; ?></td>
                <td><?= $produto->nome; ?></td>

            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

<table>
    <tr>
        <td>ID</td>
        <td>Nome</td>
        <td>Descrição</td>
        <td>Quantidade</td>
        <td>Preço</td>
    </tr>
    <?php if($produtos) : ?>
        <?php foreach($produtos as $produto) : ?>
            <tr>
                <td><?php echo $produto->id;?></td>
                <td><?php echo $produto->nome;?></td>
                <td><?php echo $produto->descricao;?></td>
                <td><?php echo $produto->quantidade;?></td>
                <td><?php echo $produto->preco;?></td>
                <td><a href="atualizar.php?alterar=<?= $produto->id ?>">Alterar</a></td>
                <td><a href="index.php?excluir=<?= $produto->id ?>">Excluir</a></td>

            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

</body>
</html>
