<?php
session_start();
if (!isset($_SESSION['usuario']) || strtolower($_SESSION['funcao']) !== 'gerente') {
    header("Location: loginfuncionario.php");
    exit();
}
include_once("objetos/FuncionarioController.php");

$controller = new FuncionarioController();

// Verifica se o ID do funcionário foi passado via GET na URL
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["excluir"])) {
    // Atenção: A função excluirFuncionario no controller possui um header("location:index.php")
    // que fará o sistema tentar redirecionar para loja/uploads/index.php em vez de loja/index.php.
    // O ideal seria ajustar isso no controller ou mover esse arquivo para a pasta raiz da loja!
    $controller->excluirFuncionario($_GET["excluir"]);
} else {
    // Redirecionamento de segurança
    header("Location: index.php");
    exit();
}
