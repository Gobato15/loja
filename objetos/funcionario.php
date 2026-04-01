<?php

Class funcionario {
    public $id;
    public $nome;
    public $cpf;
    public $endereco;
    public $telefone;
    public $funcao;
    public $login;
    public $senha;
    public $imagem;
    public $bd;

    public function __construct($bd){
        $this->bd = $bd;
    }

    public function lerTodos(){
        $sql = "SELECT * FROM funcionario";
        $resultado = $this->bd->query($sql);
        $resultado -> execute();

        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function pesquisaFuncionario($pesquisa, $tipo){
        if($tipo == "id"){
            $sql = "SELECT * FROM funcionario WHERE id = :pesquisa";
        } else if($tipo == "cpf"){
            $sql = "SELECT * FROM funcionario WHERE cpf = :pesquisa";
        } else {
            $sql = "SELECT * FROM funcionario WHERE nome LIKE :pesquisa";
            $pesquisa = "%".$pesquisa."%";
        }
        $resultado = $this->bd->prepare($sql);
        $resultado -> bindParam(':pesquisa', $pesquisa);
        $resultado -> execute();

        return $resultado->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastrar(){
        $sql = "INSERT INTO funcionario (nome, cpf, endereco, telefone, funcao, login, senha, imagem) VALUES(:nome, :cpf, :endereco, :telefone, :funcao, :login, :senha, :imagem)";

        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':login', $this->login, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $this->senha, PDO::PARAM_STR);
        $stmt->bindParam(':imagem', $this->imagem, PDO::PARAM_STR);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function excluir(){
        $sql = "DELETE FROM funcionario WHERE id = :id";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function atualizar(){
        $sql = "UPDATE funcionario SET nome = :nome, cpf = :cpf, endereco = :endereco, 
                  telefone = :telefone, funcao = :funcao, login = :login, senha = :senha";
        if($this->imagem != null){
            $sql .= ", imagem = :imagem";
        }
        $sql .= " WHERE id = :id";

        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':login', $this->login, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $this->senha, PDO::PARAM_STR);
        if($this->imagem != null){
            $stmt->bindParam(':imagem', $this->imagem, PDO::PARAM_STR);
        }
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function buscaFuncionario($id){
        $sql = "SELECT * FROM funcionario WHERE id = :id";
        $resultado = $this->bd->prepare($sql);
        $resultado->bindParam(':id', $id);
        $resultado->execute();

        return $resultado->fetch(PDO::FETCH_OBJ);
    }

    public function loginModel(){
        $sql = "SELECT * FROM funcionario WHERE login = :login LIMIT 1";
        $stmt = $this->bd->prepare($sql);
        $stmt->bindParam(':login', $this->login, PDO::PARAM_STR);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        
        if($user && trim($user->senha) === trim($this->senha)){
            return $user;
        }
        return false;
    }

}
