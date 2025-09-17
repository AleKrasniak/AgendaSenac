<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'inc/header.inc.php';
include 'classes/contatos.class.php';
include 'classes/funcoes.class.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$contato = new Contatos();
$fn = new Funcoes();
?>

<h1>Agenda Senac 2025</h1>

<p>Bem-vindo, <?= htmlspecialchars($usuario['nome']) ?>! <a href="logout.php">Sair</a></p>

<button><a href="adicionarContato.php">Adicionar Contato</a></button>

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
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'inc/footer.inc.php'; ?>
