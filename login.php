<?php
session_start();

$usuarios = [
    ['cpf' => '12345678901', 'senha' => 'senha123', 'nome' => 'João Silva'],
    ['cpf' => '98765432100', 'senha' => 'senha456', 'nome' => 'Maria Souza']
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    foreach ($usuarios as $usuario) {
        if ($usuario['cpf'] == $cpf && $usuario['senha'] == $senha) {
            $_SESSION['nome'] = $usuario['nome'];
            header("Location: menu.php");
            exit();
        }
    }
    
    echo "<script>alert('CPF ou senha incorretos.');</script>";
}
?>