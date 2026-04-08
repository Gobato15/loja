<?php

Class cliente {
    public $id;
    public $nome;
    public $email;
    public $senha;
    public $cpf;
    public $endereco;
    public $telefone;
    public $imagem;
    public $bd;

    public function __construct($bd){
        $this->bd = $bd;
    }

    public function cadastrar(){
        $sql = "INSERT INTO clientes (nome, email, senha, cpf, endereco, telefone, imagem) 
                VALUES(:nome, :email, :senha, :cpf, :endereco, :telefone, :imagem)";

        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':imagem', $this->imagem);

        return $stmt->execute();
    }

    public function login(){
        $sql = "SELECT * FROM clientes WHERE email = :email LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        
        if($user && password_verify($this->senha, $user->senha)){
            return $user;
        }
        // Fallback para senha sem hash (se houver dados antigos, embora tenhamos acabado de criar a tabela)
        if($user && trim($this->senha) === trim($user->senha)){
            return $user;
        }
        return false;
    }

    public function buscarPorId($id){
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
?>
