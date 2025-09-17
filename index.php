<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include 'inc/header.inc.php';
include 'classes/usuario.class.php';

$usuarioObj = new Usuario();
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $senha2 = $_POST['senha2'] ?? '';

    if ($senha !== $senha2) {
        $mensagem = "As senhas não coincidem.";
    } else {
        $resultado = $usuarioObj->cadastrar($nome, $email, $senha);
        if ($resultado === TRUE) {
            $mensagem = "Cadastro realizado com sucesso! Você pode fazer login agora.";
        } else {
            $mensagem = "Erro no cadastro: " . $resultado;
        }
    }
}
?>

<h1>Cadastro de Usuário</h1>

<?php if ($mensagem): ?>
    <p><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<form method="post">
    Nome: <input type="text" name="nome" required><br>
    E-mail: <input type="email" name="email" required><br>
    Senha: <input type="password" name="senha" required><br>
    Confirmar Senha: <input type="password" name="senha2" required><br>
    <button type="submit">Cadastrar</button>
</form>

<p>Já tem conta? <a href="login.php">Faça login aqui</a></p>

<!-- <?php include 'inc/footer.inc.php'; ?> -->
