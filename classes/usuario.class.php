<?php
require 'conexao.class.php';

class Usuario {
    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }

    // Verifica se email já existe (para cadastro e edição)
    private function existeEmail($email, $ignoreId = null) {
        if ($ignoreId) {
            $sql = $this->con->conectar()->prepare("SELECT ID FROM usuario WHERE email = :email AND ID != :id");
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->bindParam(':id', $ignoreId, PDO::PARAM_INT);
        } else {
            $sql = $this->con->conectar()->prepare("SELECT ID FROM usuario WHERE email = :email");
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
        }
        $sql->execute();
        return $sql->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Cadastro de usuário (senha será armazenada com hash)
    public function cadastrar($nome, $email, $senha) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verifica se já existe algum ADM no sistema
        $stmt = $this->con->conectar()->query("SELECT COUNT(*) FROM usuario WHERE FIND_IN_SET('adm', permissoes)");
        $temAdm = $stmt->fetchColumn();

        // Se não existe, este será o primeiro ADM
        $permissoes = $temAdm == 0 ? 'adm' : 'usuario';

        $sql = $this->con->conectar()->prepare("INSERT INTO usuario (nome, email, senha, permissoes) VALUES (?, ?, ?, ?)");
        if ($sql->execute([$nome, $email, $senhaHash, $permissoes])) {
            return TRUE;
        } else {
            return $sql->errorInfo()[2];
        }
    }

    // Login: verifica email e senha, retorna dados do usuário se ok
    public function login($email, $senha) {
        try {
            $sql = $this->con->conectar()->prepare("SELECT * FROM usuario WHERE email = :email");
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->execute();
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);
            if ($usuario && password_verify($senha, $usuario['senha'])) {
                unset($usuario['senha']);
                return $usuario;
            } else {
                return FALSE;
            }
        } catch (PDOException $ex) {
            return FALSE;
        }
    }

    // Listar todos os usuários (para admin)
    public function listar() {
        try {
            $sql = $this->con->conectar()->prepare("SELECT ID, nome, email, permissoes FROM usuario ORDER BY ID ASC");
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return [];
        }
    }

    // Buscar usuário por ID
    public function buscar($id) {
        try {
            $sql = $this->con->conectar()->prepare("SELECT ID, nome, email, permissoes FROM usuario WHERE ID = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();
            return $sql->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            return [];
        }
    }

    // Editar usuário (admin pode editar qualquer usuário)
    public function editar($id, $nome, $email, $senha = null, $permissoes = null) {
        if (!empty($this->existeEmail($email, $id))) {
            return 'Erro: Email já cadastrado.';
        }

        try {
            if ($senha) {
                $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
                if ($permissoes !== null) {
                    $sql = $this->con->conectar()->prepare(
                        "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, permissoes = :permissoes WHERE ID = :id"
                    );
                    $sql->bindParam(':permissoes', $permissoes, PDO::PARAM_STR);
                } else {
                    $sql = $this->con->conectar()->prepare(
                        "UPDATE usuario SET nome = :nome, email = :email, senha = :senha WHERE ID = :id"
                    );
                }
                $sql->bindParam(':senha', $hashSenha, PDO::PARAM_STR);
            } else {
                if ($permissoes !== null) {
                    $sql = $this->con->conectar()->prepare(
                        "UPDATE usuario SET nome = :nome, email = :email, permissoes = :permissoes WHERE ID = :id"
                    );
                    $sql->bindParam(':permissoes', $permissoes, PDO::PARAM_STR);
                } else {
                    $sql = $this->con->conectar()->prepare(
                        "UPDATE usuario SET nome = :nome, email = :email WHERE ID = :id"
                    );
                }
            }

            $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return 'ERRO: ' . $ex->getMessage();
        }
    }

    // Excluir usuário (apenas admin)
    public function excluir($id) {
        try {
            $sql = $this->con->conectar()->prepare("DELETE FROM usuario WHERE ID = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();
            return TRUE;
        } catch (PDOException $ex) {
            return 'ERRO: ' . $ex->getMessage();
        }
    }

    // Função para verificar se o usuário tem uma permissão específica
    public static function temPermissao($usuario, $permissao) {
        $permissoes = explode(',', $usuario['permissoes']);
        return in_array($permissao, $permissoes);
    }
}
