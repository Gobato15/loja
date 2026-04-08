<?php
require_once "config/database.php";
$db = new Database();
$con = $db->conectar();
$sql = "SELECT id, nome, imagem FROM produtos";
$stmt = $con->query($sql);
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT);
?>
