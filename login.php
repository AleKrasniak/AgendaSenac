<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'classes/usuario.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $u = new Usuario(); // cria objeto
    $usuario = $u->login($email, $senha);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario;

        // Redireciona de acordo com as permissões
        if (Usuario::temPermissao($usuario, 'adm')) {
            header("Location: index2.php");
        } else {
            header("Location: agenda.php");
        }
        exit;
    } else {
        $erro = "E-mail ou senha inválidos.";
    }
}
?>

<form method="POST">
    <label>Email:</label>
    <input type="text" name="email" required><br>

    <label>Senha:</label>
    <input type="password" name="senha" required><br>

    <button type="submit">Entrar</button>
</form>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
