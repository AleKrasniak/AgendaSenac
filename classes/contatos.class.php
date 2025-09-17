<?php
require 'conexao.class.php';

class Contatos {
    private $id;
    private $email;
    private $endereco;
    private $rede_social;
    private $telefone;
    private $nome;
    private $dtNasc;
    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }

    private function existeEmail($email, $ignoreId = null) {
        if ($ignoreId) {
            $sql = $this->con->conectar()->prepare("SELECT id FROM contatos WHERE email = :email AND id != :id");
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->bindParam(':id', $ignoreId, PDO::PARAM_INT);
        } else {
            $sql = $this->con->conectar()->prepare("SELECT id FROM contatos WHERE email = :email");
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
        }
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function adicionar($email, $endereco, $rede_social, $telefone, $nome, $dtNasc) {
        $emailExistente = $this->existeEmail($email);
        if (empty($emailExistente)) {
            try {
                $this->email = $email;
                $this->endereco = $endereco;
                $this->rede_social = $rede_social;
                $this->telefone = $telefone;
                $this->nome = $nome;
                $this->dtNasc = $dtNasc;

                $sql = $this->con->conectar()->prepare(
                    "INSERT INTO contatos(email, endereco, rede_social, telefone, nome, dtNasc) 
                    VALUES (:email, :endereco, :rede_social, :telefone, :nome, :dtNasc)"
                );
                $sql->bindParam(':email', $this->email, PDO::PARAM_STR);
                $sql->bindParam(':endereco', $this->endereco, PDO::PARAM_STR);
                $sql->bindParam(':rede_social', $this->rede_social, PDO::PARAM_STR);
                $sql->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
                $sql->bindParam(':nome', $this->nome, PDO::PARAM_STR);
                $sql->bindParam(':dtNasc', $this->dtNasc, PDO::PARAM_STR);
                $sql->execute();
                return TRUE;
            } catch (PDOException $ex) {
                return 'ERRO: ' . $ex->getMessage();
            }
        } else {
            return FALSE;
        }
    }

    public function listar() {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM contatos");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return 'ERRO: ' . $ex->getMessage();
        }
    }

    public function editar($id, $email, $endereco, $rede_social, $telefone, $nome, $dtNasc) {
        $emailExistente = $this->existeEmail($email, $id);
        if (!empty($emailExistente)) {
            return FALSE;
        } else {
            try {
                $sql = $this->con->conectar()->prepare(
                    "UPDATE contatos SET email = :email, endereco = :endereco, rede_social = :rede_social, telefone = :telefone, nome = :nome, dtNasc = :dtNasc WHERE id = :id"
                );
                $sql->bindParam(':email', $email, PDO::PARAM_STR);
                $sql->bindParam(':endereco', $endereco, PDO::PARAM_STR);
                $sql->bindParam(':rede_social', $rede_social, PDO::PARAM_STR);
                $sql->bindParam(':telefone', $telefone, PDO::PARAM_STR);
                $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
                $sql->bindParam(':dtNasc', $dtNasc, PDO::PARAM_STR);
                $sql->bindParam(':id', $id, PDO::PARAM_INT);
                $sql->execute();
                return TRUE;
            } catch (PDOException $ex) {
                return 'ERRO: ' . $ex->getMessage();
            }
        }
    }
    public function buscar($id) {
    try {
        $sql = $this->con->conectar()->prepare("SELECT * FROM contatos WHERE id = :id");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $ex) {
        return [];
    }
}

    public function excluir($id) {
        try {
            $sql = $this->con->conectar()->prepare("DELETE FROM contatos WHERE id = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return 'ERRO: ' . $ex->getMessage();
        }
    }
// DIA 01/09
    public function deletar($id){
    try {
        $sql = $this->con->conectar()->prepare("DELETE FROM contatos WHERE id = :id");
        $sql->bindValue(':id', $id, PDO::PARAM_INT);
        $sql->execute();
        return TRUE;
    } catch (PDOException $ex) {
        return 'ERRO: ' . $ex->getMessage();
    }
}



}