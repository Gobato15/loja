<?php
include_once "objetos/ProdutosController.php";

$controller = new ProdutosController();
$produtos = $controller->index();
global $produtos;

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Loja</title>
    <style>
        /* Estilização da Tabela */
        table,tr,td{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<h1>Loja</h1>
<h2>Produtos Cadastrados</h2>

<table>
    <td>Nome</td>
    <td>Descricao</td>
    <td>Quantidade</td>
    <td>Preco</td>
    </tr>
    <?php if($produtos) :?>
        <?php foreach($produtos as $produto) :?>
            <tr>
                <td><?php echo $produto ->nome; ?></td>
                <td><?php echo $produto ->descricao; ?></td>
                <td><?php echo $produto ->quantidade; ?></td>
                <td><?php echo $produto ->preco; ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

</body>

</html>
