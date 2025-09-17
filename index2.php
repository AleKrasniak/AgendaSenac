<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'inc/header.inc.php';
include 'classes/contatos.class.php';
include 'classes/funcoes.class.php';

$contato = new Contatos();
$fn = new funcoes();
?>

<h1>Agenda Senac 2025</h1>
<button><a href="adicionarContato.php">ADICIONAR</a></button>

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
                <td><?php echo $item['ativo']; ?></td>
                <td>
                    <a href="editar.Contato.php?id=<?php echo $item['id']; ?>">Editar</a>
                    <a href="excluirContato.php?id=<?php echo $item['id']; ?>"onclick="return confirm('Você tem certeza que deseja excluir??')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'inc/footer.inc.php'; ?>
