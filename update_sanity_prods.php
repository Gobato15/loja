<?php
require_once "config/database.php";
$db = new Database();
$con = $db->conectar();

// 1. Limpar espaços extras
$con->exec("UPDATE produtos SET nome = TRIM(nome), imagem = TRIM(imagem), descricao = TRIM(descricao)");

// 2. Remover duplicata #8
$con->exec("DELETE FROM produtos WHERE id = 8");

// 3. Garantir que todos tem imagens dos nossos arquivos locais
$updates = [
    ['id' => 2, 'nome' => 'Teclado Mecânico RGB', 'imagem' => 'teclado.png'],
    ['id' => 3, 'nome' => 'Monitor LED 24"', 'imagem' => 'monitor.png'],
    ['id' => 5, 'nome' => 'Mouse Gamer Pro', 'imagem' => 'mouse.png'],
    ['id' => 6, 'nome' => 'Headset 7.1 Surround', 'imagem' => 'headset.png'],
    ['id' => 7, 'nome' => 'SSD 1TB NVMe', 'imagem' => 'ssd.png'],
    ['id' => 9, 'nome' => 'Notebook Gamer High', 'imagem' => 'laptop.png'],
    ['id' => 10, 'nome' => 'Cadeira Gamer Extreme', 'imagem' => 'cadeira.png'],
    ['id' => 11, 'nome' => 'Placa de Vídeo RTX 4070', 'imagem' => 'gpu.png'],
    ['id' => 13, 'nome' => 'Placa Mãe Z790', 'imagem' => 'placamae.png'],
    ['id' => 14, 'nome' => 'Webcam Full HD 1080p', 'imagem' => 'webcam.png']
];

$stmt = $con->prepare("UPDATE produtos SET nome = :nome, imagem = :imagem WHERE id = :id");
foreach($updates as $u) {
    $stmt->execute($u);
}

echo "Sanitização concluída!";
?>
