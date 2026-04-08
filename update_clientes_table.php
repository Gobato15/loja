<?php
require_once "config/database.php";
$db = new Database();
$con = $db->conectar();
try {
    $con->exec("ALTER TABLE clientes ADD COLUMN imagem VARCHAR(255) NULL AFTER telefone");
    echo "Coluna imagem adicionada à tabela clientes!";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
