<?php
session_start();
require 'Usuario.php';

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

$permissoesDisponiveis = ['usuario', 'adm', 'gerente']; // Exemplo terceira permissão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'] ?: null; // se vazio, não altera
    $permissoesSelecionadas = $_POST['permissoes'] ?? [];
    $permissoesStr = implode(',', $permissoesSelecionadas);

    $resultado = $usuarioObj->editar($id, $nome, $email, $senha, $permissoesStr);
    if ($resultado === TRUE) {
        echo "Usuário atualizado com sucesso.";
        // redirecionar ou mostrar mensagem
    } else {
        echo "Erro: " . $resultado;
    }
}

?>

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
