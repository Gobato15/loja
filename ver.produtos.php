<?php
include_once("objetos/ProdutosController.php");

$controller = new ProdutosController();

if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){
    $a = $controller->localizarProduto($_GET['id']);
}

//var_dump($a);

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>produtos: <?= $a->nome ?></title>
</head>
<body>
<a href="index.php">Voltar</a>
<h1>#<?= $a->id ?> - <?= $a->id ?></h1>
<p><strong>Nome:</strong><?=$a->nome ?></p>
<p><strong>Descricao:</strong><?=$a->descricao ?></p>
<p><strong>Quantidade:</strong><?=$a->quantidade ?></p>
<p><strong>Preco:</strong><?=$a->preco ?></p>
<p><strong>Imagem:</strong><?=$a->imagem ?></p>
<!--Duplicar as Linhas CTRL+D-->
<!--Mostrar imagem na Tabela-->

<?php if(is_null($a->imagem)): ?>
    <img style="width: 20%;" src="imagens/img_fail.jpg"> <!-- ✅ fallback -->
<?php else: ?>
    <img style="width: 20%;" src="uploads/<?= $a->imagem ?>"> <!-- ✅ tag fechada -->

<?php endif; ?>

</body>
</html>

