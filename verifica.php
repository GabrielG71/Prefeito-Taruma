<?php 
// Inicia a sessão para armazenar dados do usuário
session_start();

// Inclui arquivo de conexão com o banco de dados
require 'connection.php';

// Verifica se o usuário não está logado (ID não existe ou está vazio)
if (!isset($_SESSION['idu']) || empty($_SESSION['idu'])) {
    // Redireciona para a página inicial se não estiver autenticado
    header("Location: index.html");
    // Encerra a execução do script
    exit;
}

// Inclui a classe Usuario uma única vez
require_once 'Usuario.Class.php';

// Cria uma nova instância da classe Usuario
$u = new Usuario();

// Busca informações do usuário logado usando o ID da sessão
$listLogged = $u->logged($_SESSION['idu']);

// Verifica se o nome do usuário foi retornado
if (!empty($listLogged['nome'])) {
    // Armazena o nome do usuário na sessão, com proteção contra XSS
    $_SESSION['nome'] = htmlspecialchars($listLogged['nome']);
} else {
    // Define um nome padrão caso não encontre o nome do usuário
    $_SESSION['nome'] = "Usuário";
}
?>
