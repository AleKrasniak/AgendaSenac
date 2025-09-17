<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'inc/header.inc.php';
include 'classes/contatos.class.php';
include 'classes/funcoes.class.php';
include 'classes/usuario.class.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$contato = new Contatos();
$fn = new funcoes();

?>

<h1>Agenda Senac 2025</h1>

<p>Bem-vindo, <?= htmlspecialchars($usuario['nome']) ?>! <a href="logout.php">Sair</a></p>

<?php if (Usuario::temPermissao($usuario, 'adm')): ?>
    <p><a href="usuarios.php"><button>Gerenciar Usuários</button></a></p>
<?php endif; ?>

<button><a href="adicionarContato.php">ADICIONAR CONTATO</a></button>

<table border="2" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>E-mail</th>
            <th>Endereço</th>
            <th>Rede Social</th>
            <th>Telefone</th>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>Foto</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $lista = $contato->listar();
        foreach($lista as $item): ?>
            <tr>
                <td><?= $item['id']; ?></td>
                <td><?= htmlspecialchars($item['email']); ?></td>
                <td><?= htmlspecialchars($item['endereco']); ?></td>
                <td><?= htmlspecialchars($item['rede_social']); ?></td>
                <td><?= htmlspecialchars($item['telefone']); ?></td>
                <td><?= htmlspecialchars($item['nome']); ?></td>
                <td><?= $fn->dtNasc($item['dtNasc'], 2); ?></td>
                <td><?= htmlspecialchars($item['foto']); ?></td>
                <td><?= $item['ativo'] ? 'Sim' : 'Não'; ?></td>
                <td>
                    <a href="editarContato.php?id=<?= $item['id']; ?>">Editar</a>
                    <a href="excluirContato.php?id=<?= $item['id']; ?>" onclick="return confirm('Você tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'inc/footer.inc.php'; ?>
