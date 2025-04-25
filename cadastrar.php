<?php
// Verifica se o usuário está logado
require 'verifica.php';

// Verifica se os dados obrigatórios foram enviados
if (isset($_POST['nome'], $_POST['cpf'], $_POST['sit'], $_POST['admin'], $_POST['local_embarque'], $_POST['local_desembarque'])) {
    // Pega os dados do formulário
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $nome = addslashes($_POST['nome']);
    $cpf = addslashes($_POST['cpf']);
    $sit = addslashes($_POST['sit']);
    $admin = (int)$_POST['admin'];
    $local_embarque = addslashes($_POST['local_embarque']);
    $local_desembarque = addslashes($_POST['local_desembarque']);

    // Se tiver ID, é edição
    if ($id) {
        // Atualiza dados do usuário
        $sql = $pdo->prepare("UPDATE usuarios SET nome = :nome, sit = :sit, admin = :admin WHERE iduser = :id");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":sit", $sit);
        $sql->bindValue(":admin", $admin);
        $sql->bindValue(":id", $id);
        $sql->execute();

        // Atualiza locais de embarque e desembarque
        $sql = $pdo->prepare("UPDATE embarque_desembarque 
                              SET local_embarque = :local_embarque, local_desembarque = :local_desembarque 
                              WHERE iduser = :id");
        $sql->bindValue(":local_embarque", $local_embarque);
        $sql->bindValue(":local_desembarque", $local_desembarque);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
    } else {
        // Verifica se o CPF já está cadastrado
        $sql = $pdo->prepare("SELECT iduser FROM usuarios WHERE cpf = :cpf");
        $sql->bindValue(":cpf", $cpf);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            echo "CPF já cadastrado!";
            exit;
        }

        // Cadastra novo usuário
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql = $pdo->prepare("INSERT INTO usuarios (nome, cpf, pass, sit, admin) VALUES (:nome, :cpf, :senha, :sit, :admin)");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":sit", $sit);
        $sql->bindValue(":admin", $admin);
        $sql->execute();

        // Pega o ID do novo usuário
        $iduser = $pdo->lastInsertId();

        // Cadastra locais de embarque e desembarque
        $sql = $pdo->prepare("INSERT INTO embarque_desembarque (iduser, local_embarque, local_desembarque) VALUES (:iduser, :local_embarque, :local_desembarque)");
        $sql->bindValue(":iduser", $iduser);
        $sql->bindValue(":local_embarque", $local_embarque);
        $sql->bindValue(":local_desembarque", $local_desembarque);
        $sql->execute();
    }

    // Redireciona após a operação
    echo "Operação realizada com sucesso!";
    header("Location: cadastro.php");
    exit;
}
?>
