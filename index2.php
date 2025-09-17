<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include 'inc/header.inc.php';
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

<p>Bem-vindo, <?php echo $usuario['nome']; ?>! <a href="logout.php">Sair</a></p>

<?php if (Usuario::temPermissao($usuario, 'adm')): ?>
    <p>
        <a href="usuarios.php"><button>Gerenciar Usuários</button></a>
        <a href="adicionarContato.php"><button>Adicionar Contato</button></a>
    </p>
<?php else: ?>
    <p>
        <a href="agenda.php"><button>Visualizar Agenda</button></a>
    </p>
<?php endif; ?>

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
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['email']; ?></td>
                <td><?php echo $item['endereco']; ?></td>
                <td><?php echo $item['rede_social']; ?></td>
                <td><?php echo $item['telefone']; ?></td>
                <td><?php echo $item['nome']; ?></td>
                <td><?php echo $fn->dtNasc($item['dtNasc'], 2); ?></td>
                <td><?php echo $item['foto']; ?></td>
                <td><?php echo $item['ativo'] ? 'Sim' : 'Não'; ?></td>
                <td>
                    <?php if (Usuario::temPermissao($usuario, 'adm')): ?>
                        <a href="editar.Contato.php?id=<?php echo $item['id']; ?>">Editar</a>
                        <a href="excluirContato.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Você tem certeza que deseja excluir?')">Excluir</a>
                    <?php else: ?>
                        Apenas visualização
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- <?php include 'inc/footer.inc.php'; ?> -->
