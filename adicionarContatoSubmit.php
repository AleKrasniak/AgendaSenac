<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

    if(!empty($_POST['email'])){
        $email = $_POST['email'];
        $endereco = $_POST['endereco'];
        $rede_social = $_POST['rede_social'];
        $telefone = $_POST['telefone'];
        $nome = $_POST['nome'];
        $dtNasc = $_POST['dtNasc'];
        $contato->adicionar($email, $endereco, $rede_social, $telefone,$nome, $dtNasc);
        header('Location: index.php');
    } else {
        echo '<script type="text/javascript">alert("Email já cadastrado!")</script>';
    }


?>

