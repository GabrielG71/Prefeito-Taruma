<?php 
session_start();
require 'connection.php';

if (!isset($_SESSION['idu']) || empty($_SESSION['idu'])) {
    header("Location: index.html");
    exit;
}

require_once 'Usuario.Class.php';
$u = new Usuario();
$listLogged = $u->logged($_SESSION['idu']);

if (!empty($listLogged['nome'])) {
    $_SESSION['nome'] = htmlspecialchars($listLogged['nome']);
} else {
    $_SESSION['nome'] = "Usuário";
}
?>