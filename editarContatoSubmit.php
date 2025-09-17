<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if(!empty($_POST['id'])){
    $id = $_POST['id'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $rede_social = $_POST['rede_social'];
    $telefone = $_POST['telefone'];
    $nome = $_POST['nome'];
    $dtNasc = $_POST['dtNasc'];

    if(!empty($email)){
        $contato->editar($id, $email, $endereco, $rede_social, $telefone,$nome, $dtNasc);
        header('Location: index.php');
    }
}




?>