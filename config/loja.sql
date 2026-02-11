SHOW DATABASES;

CREATE DATABASE loja;
USE loja;

CREATE TABLE Produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    quantidade INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL
);

SHOW TABLES;

INSERT INTO Produtos (nome, descricao, quantidade, preco) VALUES
('Mouse', 'Mouse óptico USB', 50, 39.90),
('Teclado', 'Teclado mecânico', 20, 199.90),
('Monitor', 'Monitor LED 24 polegadas', 10, 899.99);

SELECT * FROM Produtos;