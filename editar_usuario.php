<?php
session_start();
require 'classes/usuario.class.php';

// Apenas ADM pode acessar
if (!isset($_SESSION['usuario']) || !Usuario::temPermissao($_SESSION['usuario'], 'adm')) {
    header('Location: login.php');
    exit;
}

$usuarioObj = new Usuario();
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID do usuário não informado.");
}

$usuarioEditar = $usuarioObj->buscar($id);
if (!$usuarioEditar) {
    die("Usuário não encontrado.");
}

// Permissões disponíveis no sistema
$permissoesDisponiveis = ['usuario', 'adm', 'gerente'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'] ?: null; // se vazio, não altera
    $permissoesSelecionadas = $_POST['permissoes'] ?? [];
    $permissoesStr = implode(',', $permissoesSelecionadas);

    $resultado = $usuarioObj->editar($id, $nome, $email, $senha, $permissoesStr);
    if ($resultado === TRUE) {
        header("Location: usuarios.php?msg=atualizado");
        exit;
    } else {
        echo "<p style='color:red;'>Erro: $resultado</p>";
    }
}
?>

<h1>Editar Usuário</h1>

<form method="post">
    Nome: <input type="text" name="nome" value="<?= htmlspecialchars($usuarioEditar['nome']) ?>" required><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($usuarioEditar['email']) ?>" required><br>
    Senha (deixe vazio para não alterar): <input type="password" name="senha"><br>
    Permissões:<br>
    <?php foreach ($permissoesDisponiveis as $perm): ?>
        <label>
            <input type="checkbox" name="permissoes[]" value="<?= $perm ?>"
                <?= in_array($perm, explode(',', $usuarioEditar['permissoes'])) ? 'checked' : '' ?>>
            <?= ucfirst($perm) ?>
        </label><br>
    <?php endforeach; ?>
    <button type="submit">Salvar</button>
</form>

<p><a href="usuarios.php">Voltar</a></p>
