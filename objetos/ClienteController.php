<?php
include_once __DIR__ . "/../config/database.php";
include_once __DIR__ . "/cliente.php";

Class ClienteController {
    private $bd;
    private $cliente;

    public function __construct() {
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->cliente = new cliente($this->bd);
    }

    public function upload($arquivo) {
        $target_dir = "uploads/";
        $imageFileType = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));
        $random_name = uniqid('client_', true) . '.' . $imageFileType;
        $upload_file = $target_dir . $random_name;
        
        if (move_uploaded_file($arquivo['tmp_name'], $upload_file)) {
            return $random_name;
        }
        return null;
    }

    public function cadastrar($dados, $arquivo = null) {
        $this->cliente->nome = $dados['nome'];
        $this->cliente->email = $dados['email'];
        $this->cliente->senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
        $this->cliente->cpf = $dados['cpf'];
        $this->cliente->endereco = $dados['endereco'];
        $this->cliente->telefone = $dados['telefone'];
        
        if($arquivo && $arquivo['error'] === UPLOAD_ERR_OK){
            $this->cliente->imagem = $this->upload($arquivo);
        } else {
            $this->cliente->imagem = null;
        }

        if($this->cliente->cadastrar()){
            header("Location: login_cliente.php?msg=sucesso");
            exit();
        } else {
            return "Erro ao cadastrar cliente.";
        }
    }

    public function login($email, $senha) {
        $this->cliente->email = $email;
        $this->cliente->senha = $senha;
        $dados = $this->cliente->login();

        if($dados){
            if(session_status() === PHP_SESSION_NONE) { session_start(); }
            $_SESSION['id'] = $dados->id;
            $_SESSION['usuario'] = $dados->email;
            $_SESSION['nome_usuario'] = $dados->nome;
            $_SESSION['imagem_usuario'] = $dados->imagem;
            $_SESSION['tipo_usuario'] = 'cliente';
            $_SESSION['funcao'] = 'cliente';

            header("Location: index.php");
            exit();
        } else {
            return "Email ou senha incorretos.";
        }
    }
}
?>
