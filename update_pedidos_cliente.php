<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

try {
    // Tenta dropar as tabelas antigas para recriar com a lógica de clientes
    // Itens_pedido deve ser dropada primeiro por causa da FK
    $con->exec("DROP TABLE IF EXISTS itens_pedido");
    $con->exec("DROP TABLE IF EXISTS pedidos");
    
    $sql_pedidos = "CREATE TABLE pedidos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_id INT NOT NULL,
        data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10,2) NOT NULL,
        status VARCHAR(50) DEFAULT 'Pendente',
        FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;";

    $sql_itens = "CREATE TABLE itens_pedido (
        id INT AUTO_INCREMENT PRIMARY KEY,
        pedido_id INT NOT NULL,
        produto_id INT NOT NULL,
        quantidade INT NOT NULL,
        preco_unitario DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
        FOREIGN KEY (produto_id) REFERENCES produtos(id)
    ) ENGINE=InnoDB;";

    $con->exec($sql_pedidos);
    $con->exec($sql_itens);
    echo "Tabelas de pedidos atualizadas para vincular a clientes!";
} catch (PDOException $e) {
    echo "Erro ao atualizar tabelas: " . $e->getMessage();
}
?>
