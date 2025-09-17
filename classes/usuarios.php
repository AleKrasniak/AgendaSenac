<?php
session_start();
require_once __DIR__ . "/conexao.class.php";

// Apenas ADM pode acessar
if (!isset($_SESSION['usuario']) || !Usuario::temPermissao($_SESSION['usuario'], 'adm')) {
    header('Location: login.php');
    exit;
}

$usuarioObj = new Usuario();
$listaUsuarios = $usuarioObj->listar(); // Pega todos os usuários
?>

<h1>Gerenciar Usuários</h1>
<p><a href="index2.php">Voltar para o painel</a></p>
<p><a href="adicionarUsuario.php"><button>Adicionar Usuário</button></a></p>

<table border="2" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Permissões</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaUsuarios as $u): ?>
            <tr>
                <td><?php echo $u['ID']; ?></td>
                <td><?php echo $u['nome']; ?></td>
                <td><?php echo $u['email']; ?></td>
                <td><?php echo $u['permissoes']; ?></td>
                <td>
                    <a href="editarUsuario.php?id=<?php echo $u['ID']; ?>">Editar</a> |
                    <a href="excluirUsuario.php?id=<?php echo $u['ID']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
