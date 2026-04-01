<?php
// Resolvendo problema de caminhos quando o controller é chamado de uma pasta diferente (ex: uploads)
include_once __DIR__ . "/../config/database.php";
include_once __DIR__ . "/funcionario.php";

Class FuncionarioController {
    private $bd;
    private $funcionario;
    private $img_name;

    public function __construct() {
        $banco = new Database();
        $this->bd = $banco->conectar();
        $this->funcionario = new funcionario($this->bd);
    }

    public function index() {
        return $this->funcionario->lerTodos();
    }

    public function pesquisaFuncionario($pesquisa, $tipo){
        return $this->funcionario->pesquisaFuncionario($pesquisa, $tipo);
    }

    public function upload($arquivo)
    {
        $target_dir = "uploads/";
        $uploadOk = 1;
        $target_file = $target_dir . basename($arquivo["name"]['fileToUpload']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $random_name = uniqid('img_', true) . '.' . $imageFileType;
        $this->img_name = $random_name;
        $upload_file = $target_dir . $random_name;

        $check = getimagesize($arquivo['tmp_name']['fileToUpload']);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if (file_exists($upload_file)) {
            $uploadOk = 0;
        }

        if ($arquivo['size']['fileToUpload'] > 5000000) {
            $uploadOk = 0;
            echo "<script>alert('Imagem muito grande.');</script>";
            die();
        }
        
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "<script>alert('Somente JPG, JPEG, PNG e GIF são aceitos.');</script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            return false;
        } else {
            if (move_uploaded_file($arquivo['tmp_name']['fileToUpload'], $upload_file)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function cadastrarFuncionario($dados, $arquivo = null)
    {
        $temArquivo = isset($arquivo['name']['fileToUpload'])
            && $arquivo['name']['fileToUpload'] !== ""
            && isset($arquivo['error']['fileToUpload'])
            && $arquivo['error']['fileToUpload'] === UPLOAD_ERR_OK;

        if($temArquivo && !$this->upload($arquivo)){
            return false;
        }

        if(!$temArquivo){
            $this->img_name = null;
        }

        $this->funcionario->nome = $dados["nome"];
        $this->funcionario->cpf = $dados["cpf"];
        $this->funcionario->endereco = $dados["endereco"];
        $this->funcionario->telefone = $dados["telefone"];
        $this->funcionario->funcao = $dados["funcao"];
        $this->funcionario->login = $dados["login"];
        // Recomendado usar password_hash() aqui num cenário real
        $this->funcionario->senha = $dados["senha"]; 
        $this->funcionario->imagem = $this->img_name;

        if ($this->funcionario->cadastrar()) {
            header("location: painelgerenciamento.php");
            exit();
        }
    }

    public function excluirFuncionario($id)
    {
        $this->funcionario->id = $id;

        if ($this->funcionario->excluir()) {
            header("location: painelgerenciamento.php");
        }
    }

    public function atualizarFuncionario($dados, $arquivo = null)
    {
        $temArquivo = isset($arquivo['name']['fileToUpload'])
            && $arquivo['name']['fileToUpload'] !== ""
            && isset($arquivo['error']['fileToUpload'])
            && $arquivo['error']['fileToUpload'] === UPLOAD_ERR_OK;

        if($temArquivo && !$this->upload($arquivo)){
            return false;
        }

        if(!$temArquivo){
            $this->funcionario->imagem = null;
        } else {
            $this->funcionario->imagem = $this->img_name;
        }

        $this->funcionario->id = $dados["id"];
        $this->funcionario->nome = $dados["nome"];
        $this->funcionario->cpf = $dados["cpf"];
        $this->funcionario->endereco = $dados["endereco"];
        $this->funcionario->telefone = $dados["telefone"];
        $this->funcionario->funcao = $dados["funcao"];
        $this->funcionario->login = $dados["login"];
        $this->funcionario->senha = $dados["senha"];

        if ($this->funcionario->atualizar()) {
            header("location: painelgerenciamento.php");
            exit();
        }
    }

    public function localizarFuncionario($id)
    {
        return $this->funcionario->buscaFuncionario($id);
    }

    public function login($login, $senha) {
        $this->funcionario->login = $login;
        $this->funcionario->senha = $senha;
        $dadosLogin = $this->funcionario->loginModel();

        if ($dadosLogin) {
            if(session_status() === PHP_SESSION_NONE) { session_start(); }
            $_SESSION['id'] = $dadosLogin->id;
            $_SESSION['usuario'] = $dadosLogin->login;
            $_SESSION['nome_usuario'] = $dadosLogin->nome;
            $_SESSION['funcao'] = trim(strtolower($dadosLogin->funcao));
            
            if($_SESSION['funcao'] === 'gerente') {
                header("Location: painelgerenciamento.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            echo "<script>alert('Login ou senha inválidos!');</script>";
        }
    }

}
