<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

$sql_pedidos = "CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pendente',
    FOREIGN KEY (usuario_id) REFERENCES funcionario(id)
) ENGINE=InnoDB;";

$sql_itens = "CREATE TABLE IF NOT EXISTS itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
)";

try {
    $con->exec($sql_pedidos);
    $con->exec($sql_itens);
    echo "Tabelas de pedidos e itens_pedido criadas com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage();
}
?>
