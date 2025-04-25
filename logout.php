<?php
// Inicia ou resume a sessão atual
session_start();

// Remove a variável de sessão 'idu' que armazena o ID do usuário logado
unset($_SESSION['idu']);

// Redireciona o usuário para a página inicial (index.html)
header("Location: index.html");

// Encerra a execução do script imediatamente após o redirecionamento
exit;
?>
