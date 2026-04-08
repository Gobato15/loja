<?php
require_once "config/database.php";

$db = new Database();
$con = $db->conectar();

$updates = [
    ['id' => 7, 'imagem' => 'ssd.png'],
    ['id' => 11, 'imagem' => 'gpu.png'],
    ['id' => 13, 'imagem' => 'placamae.png'],
    ['id' => 14, 'imagem' => 'webcam.png'],
    ['id' => 10, 'imagem' => 'cadeira.png']
];

$sql = "UPDATE produtos SET imagem = :imagem WHERE id = :id";
$stmt = $con->prepare($sql);

foreach ($updates as $p) {
    $stmt->execute([
        ':imagem' => $p['imagem'],
        ':id' => $p['id']
    ]);
}

echo "Imagens restantes atualizadas!";
?>
