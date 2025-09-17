session_start();

require 'classes/usuario.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $usuarioObj = new Usuario();
    $usuario = $usuarioObj->login($email, $senha);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        header('Location: agenda.php'); // página com contatos
        exit;
    } else {
        $erro = "Email ou senha inválidos.";
    }
}
