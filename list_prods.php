<?php
require_once "config/database.php";
$db = new Database();
$con = $db->conectar();
$sql = "SELECT id, nome FROM produtos";
$stmt = $con->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($produtos);
?>
