<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

$sql = "UPDATE produtos SET nome = 'SSD 1TB NVMe', descricao = 'Velocidade de leitura de até 3500MB/s para carregar tudo instantaneamente.', preco = 489.00 WHERE id = 7";
$con->exec($sql);

echo "Produto 7 atualizado!";
?>
