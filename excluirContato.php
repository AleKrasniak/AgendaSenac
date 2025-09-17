<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'classes/contatos.class.php';
$con = new Contatos();

if(!empty($_GET['id'])){
    $id = $_GET['id']; // pega corretamente
    $resultado = $con->deletar($id); // chama o método com parênteses
    if($resultado === TRUE){
        header("Location: /agendaSenac2025");
        exit;
    } else {
        echo '<script>alert("Erro ao excluir contato: '.$resultado.'");</script>';
        header("Location: /agendaSenac2025");
        exit;
    }
}else{
    echo '<script>alert("ID inválido!");</script>';
    header("Location: /agendaSenac2025");
    exit;
}
?>
