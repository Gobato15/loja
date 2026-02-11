<?php
include_once "config/database.php";

$banco = new Database();
$bd = $banco->conectar();

if ($bd) {
    $sql = "SELECT * FROM produtos";
    $resultado = $bd->query($sql);
    $resultado ->execute();
    $resultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultado as $produtos) {
        echo "<br><h1>". $produtos['nome'] . "</h1>";
        echo "<strong>ID do produto:</strong> " . $produtos['id'] . "<br>";
        echo "<strong>Nome do produto:</strong> " . $produtos['nome'] . "<br>";
        echo "<strong>Descrição:</strong> " . $produtos['descricao'] . "<br>";
        echo "<strong>Quantidade:</strong> " . $produtos['quantidade'] . "<br>";
        echo "<strong>Preço:</strong> " . $produtos['preco'] . "<br>";
    }
}else{
    echo "Falha ao conectar banco";
}
