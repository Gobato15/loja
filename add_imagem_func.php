<?php
include_once __DIR__ . "/config/database.php";

$banco = new Database();
$bd = $banco->conectar();

$sql = "ALTER TABLE funcionario ADD COLUMN imagem VARCHAR(255) NULL";

try {
    $bd->query($sql);
    echo "Coluna imagem adicionada à tabela funcionario com sucesso!";
} catch (Exception $e) {
    if (strpos($e->getMessage(), "Duplicate column name") !== false) {
        echo "A coluna já existia.";
    } else {
        echo "Erro: " . $e->getMessage();
    }
}
?>
