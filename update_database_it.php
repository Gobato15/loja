<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

$updates = [
    [
        'id' => 2, 
        'nome' => 'Teclado Mecânico RGB', 
        'descricao' => 'Teclado gamer com switches blue, iluminação RGB e anti-ghosting.', 
        'preco' => 349.90, 
        'imagem' => 'teclado.png'
    ],
    [
        'id' => 3, 
        'nome' => 'Monitor LED 24"', 
        'descricao' => 'Monitor Full HD com taxa de atualização de 144Hz e tempo de resposta de 1ms.', 
        'preco' => 1299.00, 
        'imagem' => 'monitor.png'
    ],
    [
        'id' => 5, 
        'nome' => 'Mouse Gamer Pro', 
        'descricao' => 'Mouse ergonômico com 12.000 DPI e botões programáveis.', 
        'preco' => 189.90, 
        'imagem' => 'mouse.png'
    ],
    [
        'id' => 6, 
        'nome' => 'Headset 7.1 Surround', 
        'descricao' => 'Headset com drivers de 50mm e cancelamento de ruído.', 
        'preco' => 279.00, 
        'imagem' => 'headset.png'
    ],
    [
        'id' => 9, 
        'nome' => 'Notebook Gamer High', 
        'descricao' => 'Processador i7, 16GB RAM, SSD 512GB e RTX 3060.', 
        'preco' => 6499.00, 
        'imagem' => 'laptop.png'
    ],
    [
        'id' => 10, 
        'nome' => 'Cadeira Gamer Extreme', 
        'descricao' => 'Cadeira ergonômica com inclinação de 180 graus e almofadas inclusas.', 
        'preco' => 1190.00, 
        'imagem' => 'imagens/img_fail.jpg'
    ],
    [
        'id' => 11, 
        'nome' => 'Placa de Vídeo RTX 4070', 
        'descricao' => 'Placa de vídeo de última geração com 12GB GDDR6X.', 
        'preco' => 4590.00, 
        'imagem' => 'imagens/img_fail.jpg'
    ],
    [
        'id' => 13, 
        'nome' => 'Placa Mãe Z790', 
        'descricao' => 'Placa mãe top de linha para processadores Intel de 13ª geração.', 
        'preco' => 2200.00, 
        'imagem' => 'imagens/img_fail.jpg'
    ],
    [
        'id' => 14, 
        'nome' => 'Webcam Full HD 1080p', 
        'descricao' => 'Câmera para streaming com foco automático e microfone dual.', 
        'preco' => 299.90, 
        'imagem' => 'imagens/img_fail.jpg'
    ]
];

$sql = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, imagem = :imagem WHERE id = :id";
$stmt = $con->prepare($sql);

foreach ($updates as $p) {
    $stmt->execute([
        ':nome' => $p['nome'],
        ':descricao' => $p['descricao'],
        ':preco' => $p['preco'],
        ':imagem' => $p['imagem'],
        ':id' => $p['id']
    ]);
}

echo "Produtos atualizados com sucesso no banco de dados!";
?>
