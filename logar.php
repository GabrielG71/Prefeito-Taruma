<?php 
// Inicia a sessão para armazenar dados do usuário
session_start();

// Verifica se os campos CPF e senha foram enviados e não estão vazios
if(isset($_POST['cpf']) && !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])){
    // Inclui os arquivos necessários para a conexão e a classe de usuário
    require 'connection.php';
    require 'Usuario.Class.php';

    // Cria uma nova instância da classe Usuario
    $u = new Usuario();
    
    // Obtém e filtra os dados do formulário
    $cpf = addslashes($_POST['cpf']); // Previne SQL injection básico
    $senha = addslashes($_POST['senha']); // Previne SQL injection básico

    // Tenta fazer login com as credenciais fornecidas
    if ($u->login($cpf, $senha) == true) {
        // Se o login for bem-sucedido, verifica se a sessão foi criada
        if (isset($_SESSION['idu'])) {    
            // Redireciona para páginas diferentes baseado no nível de acesso
            if ($_SESSION['admin'] == 1) {
                header("Location: menu_admin.php"); // Administrador
            } else {
                header("Location: menu.php"); // Usuário comum
            }
            exit; // Encerra a execução após redirecionamento
        } 
    }

    // Se o login falhar, armazena mensagem de erro na sessão
    $_SESSION['erro_login'] = "CPF ou Senha incorretos!";
    header("Location: login.php"); // Redireciona de volta para a página de login
    exit; // Encerra a execução
}
?>
