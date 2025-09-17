<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'inc/header.inc.php';
include 'classes/usuario.class.php';

$usuarioObj = new Usuario();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuario = $usuarioObj->login($email, $senha);
    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        header('Location: agenda.php'); // redireciona para a agenda após login
        exit;
    } else {
        $erro = "Email ou senha inválidos.";
    }
}
?>

<h1>Login</h1>

<?php if ($erro): ?>
    <p style="color:red;"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<form method="post" action="">
    <label for="email">E-mail:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="senha">Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <button type="submit">Entrar</button>
</form>

<p>Não tem uma conta? <a href="index.php">Cadastre-se aqui</a></p>

<?php include 'inc/footer.inc.php'; ?>
