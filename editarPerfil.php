<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/classes/usuario.class.php';

// Verifica se usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuarioObj = new Usuario();
$usuario = $_SESSION['usuario'];
$erro = '';

// Processa envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? null; // opcional

    $resultado = $usuarioObj->editar($usuario['ID'], $nome, $email, $senha);

    if ($resultado === TRUE) {
        // Atualiza sessão
        $_SESSION['usuario'] = $usuarioObj->buscar($usuario['ID']);
        $usuario = $_SESSION['usuario'];
        $sucesso = "Perfil atualizado com sucesso!";
    } else {
        $erro = $resultado;
    }
}

?>

<h1>Editar Perfil</h1>
<p><a href="agenda.php">Voltar</a></p>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<?php if (!empty($sucesso)) echo "<p style='color:green;'>$sucesso</p>"; ?>

<form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required><br><br>

    <label>Senha (deixe em branco para não alterar):</label><br>
    <input type="password" name="senha"><br><br>

    <button type="submit">Salvar Alterações</button>
</form>
