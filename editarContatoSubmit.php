<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if (!empty($_POST['id']) && !empty($_POST['email'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $rede_social = $_POST['rede_social'];
    $telefone = $_POST['telefone'];
    $nome = $_POST['nome'];
    $dtNasc = $_POST['dtNasc'];

    $resultado = $contato->editar($id, $email, $endereco, $rede_social, $telefone, $nome, $dtNasc);

    if ($resultado === TRUE) {
        header("Location: index2.php");
        exit;
    } else if ($resultado === FALSE) {
        echo '<script type="text/javascript">
                alert("Email já cadastrado!");
                window.location.href = "index2.php";
              </script>';
        exit;
    } else {
        echo '<script type="text/javascript">
                alert("Erro: ' . addslashes($resultado) . '");
                window.location.href = "index2.php";
              </script>';
        exit;
    }
} else {
    header("Location: index2.php");
    exit;
}
