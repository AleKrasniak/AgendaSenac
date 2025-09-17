<?php
// Fábrica de conexões
class Conexao {
    private $usuario;
    private $senha;
    private $banco;
    private $servidor;

    private static $pdo;

    public function __construct() {
        $this->servidor = "localhost";
        $this->banco    = "agendasenac2025";
        $this->usuario  = "root";
        $this->senha    = "";
    }

    public function conectar() {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new PDO(
                    "mysql:host=".$this->servidor.";dbname=".$this->banco.";charset=utf8",
                    $this->usuario,
                    $this->senha
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$pdo;
        } catch (PDOException $ex) {
            die("Erro de conexão: " . $ex->getMessage());
        }
    }
}
