<?php
require 'classes/usuario.class.php';

$usuarioObj = new Usuario();
$senhaHash = password_hash("123456", PASSWORD_DEFAULT);

// Insere já como administrador
$sql = "INSERT INTO usuario (nome, email, senha, permissoes) VALUES (?, ?, ?, ?)";
$stmt = $usuarioObj->pdo->prepare($sql);

if ($stmt->execute(["Administrador", "admin@teste.com", $senhaHash, "adm"])) {
    echo "Administrador criado com sucesso!";
} else {
    echo "Erro: " . $stmt->errorInfo()[2];
}
