<?php
$ips_permitidos = ['127.0.0.1', '::1'];

if (!in_array($_SERVER['REMOTE_ADDR'], $ips_permitidos)) {
    http_response_code(403);
    exit("Acesso negado.");
}

require 'connection.php';

if (isset($_POST['nome'], $_POST['cpf'], $_POST['senha'], $_POST['sit'], $_POST['admin'])) {
    $nome = addslashes($_POST['nome']);
    $cpf = addslashes($_POST['cpf']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $sit = addslashes($_POST['sit']);
    $admin = (int) $_POST['admin'];

    $sql = $pdo->prepare("SELECT iduser FROM usuarios WHERE cpf = :cpf");
    $sql->bindValue(":cpf", $cpf);
    $sql->execute();

    if ($sql->rowCount() > 0) {
        echo "CPF já cadastrado!";
    } else {
        $sql = $pdo->prepare("INSERT INTO usuarios (nome, cpf, pass, sit, admin) VALUES (:nome, :cpf, :senha, :sit, :admin)");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":sit", $sit);
        $sql->bindValue(":admin", $admin);
        $sql->execute();

        echo "Cadastro realizado com sucesso!";
        header("Location: login.php");
        exit;
    }
}
?>