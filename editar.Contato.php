<?php 
require 'inc/header.inc.php';
include 'classes/contatos.class.php';
$contatos = new Contatos();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $info = $contatos->buscar($id);

    if (empty($info) || empty($info['email'])) {
        header("Location: /agendasenac2025");
        exit;
    }
} else {
    header("Location: /agendasenac2025");
    exit;
}
?>

<form method="POST" action="editarContatoSubmit.php">
    <h1 class="title">EDITAR CONTATO</h1>
    <input type="hidden" name="id" value="<?= htmlspecialchars($info['id']) ?>">
    Email: <br>
    <input type="text" name="email" value="<?= htmlspecialchars($info['email']) ?>"><br>
    Endereço: <br>
    <input type="text" name="endereco" value="<?= htmlspecialchars($info['endereco']) ?>"><br>
    Rede Social: <br>
    <input type="text" name="rede_social" value="<?= htmlspecialchars($info['rede_social']) ?>"><br>
    Telefone: <br>
    <input type="text" name="telefone" value="<?= htmlspecialchars($info['telefone']) ?>"><br>
    Nome: <br>
    <input type="text" name="nome" value="<?= htmlspecialchars($info['nome']) ?>"><br>
    Data de Nascimento: <br>
    <input type="text" name="dtNasc" value="<?= htmlspecialchars($info['dtNasc']) ?>"><br>
    <input type="submit" name="btCadastrar" value="SALVAR" class="btn-adicionar"/>
</form>

<?php require 'inc/footer.inc.php'?>