<?php
session_start();
require_once __DIR__ . "/classes/usuario.class.php";

// Apenas ADM pode excluir
if (!isset($_SESSION['usuario']) || !Usuario::temPermissao($_SESSION['usuario'], 'adm')) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: gerenciarUsuarios.php');
    exit;
}

$id = (int) $_GET['id']; // ID do usuário a excluir
$usuarioObj = new Usuario();

// Evita que ADM exclua a si mesmo
if ($id == $_SESSION['usuario']['ID']) {
    echo "<script>alert('Você não pode excluir seu próprio usuário!'); window.location.href='usuarios.php';</script>";
    exit;
}

// Exclui o usuário
$resultado = $usuarioObj->excluir($id);

if ($resultado === TRUE) {
    echo "<script>alert('Usuário excluído com sucesso!'); window.location.href='usuarios.php';</script>";
} else {
    echo "<script>alert('Erro ao excluir usuário: $resultado'); window.location.href='usuarios.php';</script>";
}
