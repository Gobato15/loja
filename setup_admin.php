<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

$sql_admin = "CREATE TABLE IF NOT EXISTS administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

try {
    $con->exec($sql_admin);
    echo "Tabela administradores criada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabela administradores: " . $e->getMessage();
}
?>
