<?php
// Configurações de conexão com o banco de dados
$localhost = "localhost:3307";  // Endereço do servidor MySQL e porta
$user = "root";                // Nome de usuário do banco de dados
$passw = "";                   // Senha do banco de dados (vazia no exemplo)
$banco = "transporte";         // Nome do banco de dados a ser conectado

// Declara a variável como global para poder ser usada em outros arquivos
global $pdo;

try {
    // Tenta estabelecer a conexão com o banco usando PDO
    $pdo = new PDO("mysql:host=$localhost;dbname=$banco", $user, $passw);
    
    // Configura o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    // Se ocorrer algum erro na conexão, exibe a mensagem e encerra o script
    echo "ERRO: ".$e->getMessage();
    exit;
}
?>
