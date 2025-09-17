<?php
session_start();
require_once __DIR__ . "/classes/usuario.class.php";

// Apenas ADM pode acessar
if (!isset($_SESSION['usuario']) || !Usuario::temPermissao($_SESSION['usuario'], 'adm')) {
    header('Location: login.php');
    exit;
}

$usuarioObj = new Usuario();
$erro = "";
$sucesso = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $permissoes = $_POST['permissoes'] ?? 'usuario'; // padrão para 'usuario'

    // Cadastro do usuário
    $resultado = $usuarioObj->cadastrar($nome, $email, $senha);

    if ($resultado === TRUE) {
        // Agora atualiza a permissão caso seja diferente do padrão
        if ($permissoes !== 'usuario') {
            $ultimoID = $usuarioObj->conectar()->lastInsertId(); // pega ID do usuário recém-criado
            $usuarioObj->editar($ultimoID, $nome, $email, $senha, $permissoes);
        }
        $sucesso = "Usuário cadastrado com sucesso!";
    } else {
        $erro = $resultado; // mensagem de erro
    }
}
?>

<h1>Adicionar Usuário</h1>
<p><a href="gerenciarUsuarios.php">Voltar</a></p>

<?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
<?php if (!empty($sucesso)) echo "<p style='color:green;'>$sucesso</p>"; ?>

<form method="POST">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <label>Permissão:</label><br>
    <select name="permissoes" required>
        <option value="usuario">Usuário</option>
        <option value="adm">Administrador</option>
    </select><br><br>

    <button type="submit">Cadastrar</button>
</form>
