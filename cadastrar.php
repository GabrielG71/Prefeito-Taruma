<?php
// Inclui arquivo que verifica se usuário está logado
require 'verifica.php';

// Verifica se todos campos obrigatórios foram enviados via POST
if (isset($_POST['nome'], $_POST['cpf'], $_POST['sit'], $_POST['admin'], $_POST['local_embarque'], $_POST['local_desembarque'])) {
    
    // Prepara dados do formulário:
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;  // ID do usuário (se edição)
    $nome = addslashes($_POST['nome']);  // Previne SQL injection básico
    $cpf = addslashes($_POST['cpf']);    // CPF do usuário
    $sit = addslashes($_POST['sit']);    // Situação do usuário
    $admin = (int)$_POST['admin'];       // Nível de admin (0 ou 1)
    $local_embarque = addslashes($_POST['local_embarque']);    // Local de embarque
    $local_desembarque = addslashes($_POST['local_desembarque']);  // Local de desembarque

    // Se tiver ID, é ATUALIZAÇÃO de cadastro existente
    if ($id) {
        // Atualiza dados principais na tabela usuarios
        $sql = $pdo->prepare("UPDATE usuarios SET nome = :nome, sit = :sit, admin = :admin WHERE iduser = :id");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":sit", $sit);
        $sql->bindValue(":admin", $admin);
        $sql->bindValue(":id", $id);
        $sql->execute();

        // Atualiza locais na tabela embarque_desembarque
        $sql = $pdo->prepare("UPDATE embarque_desembarque 
                            SET local_embarque = :local_embarque, local_desembarque = :local_desembarque 
                            WHERE iduser = :id");
        $sql->bindValue(":local_embarque", $local_embarque);
        $sql->bindValue(":local_desembarque", $local_desembarque);
        $sql->bindValue(":id", $id);
        $sql->execute();
        
    } else {  // Se NÃO tiver ID, é NOVO CADASTRO
        
        // Verifica se CPF já existe no banco
        $sql = $pdo->prepare("SELECT iduser FROM usuarios WHERE cpf = :cpf");
        $sql->bindValue(":cpf", $cpf);
        $sql->execute();

        if ($sql->rowCount() > 0) {  // Se CPF já cadastrado
            echo "CPF já cadastrado!";
            exit;
        }

        // Cria hash da senha para armazenamento seguro
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        
        // Insere novo usuário na tabela usuarios
        $sql = $pdo->prepare("INSERT INTO usuarios (nome, cpf, pass, sit, admin) VALUES (:nome, :cpf, :senha, :sit, :admin)");
        $sql->bindValue(":nome", $nome);
        $sql->bindValue(":cpf", $cpf);
        $sql->bindValue(":senha", $senha);
        $sql->bindValue(":sit", $sit);
        $sql->bindValue(":admin", $admin);
        $sql->execute();

        // Pega ID do novo usuário inserido
        $iduser = $pdo->lastInsertId();

        // Insere locais de embarque/desembarque
        $sql = $pdo->prepare("INSERT INTO embarque_desembarque (iduser, local_embarque, local_desembarque) VALUES (:iduser, :local_embarque, :local_desembarque)");
        $sql->bindValue(":iduser", $iduser);
        $sql->bindValue(":local_embarque", $local_embarque);
        $sql->bindValue(":local_desembarque", $local_desembarque);
        $sql->execute();
    }

    // Feedback e redirecionamento
    echo "Operação realizada com sucesso!";
    header("Location: cadastro.php");  // Volta para página de cadastro
    exit;
}
?>
