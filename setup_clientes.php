<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

$sql = "CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    cpf VARCHAR(20) UNIQUE,
    endereco TEXT,
    telefone VARCHAR(20),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

try {
    $con->exec($sql);
    echo "Tabela clientes criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabela clientes: " . $e->getMessage();
}
?>
