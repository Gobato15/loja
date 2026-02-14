<?php

include_once "config/database.php";
include_once "produtos.php";

class ProdutosController
{
    private $bd;
    private $produtos;

    public function __construct()
    {
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->produtos = new Produtos($this->bd);
    }

    public function index()
    {
        return $this->produtos->lerTodos();

    }
}
