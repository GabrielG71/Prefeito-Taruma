<?php 
session_start();

if(isset($_POST['cpf']) && !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])){
    require 'connection.php';
    require 'Usuario.Class.php';

    $u = new Usuario();
    
    $cpf = addslashes($_POST['cpf']);
    $senha = addslashes($_POST['senha']);

    if ($u->login($cpf, $senha) == true) {
        if (isset($_SESSION['idu'])) {    
            if ($_SESSION['admin'] == 1) {
                header("Location: menu_admin.php");
            } else {
                header("Location: menu.php");
            }
            exit;
        } 
    }

    $_SESSION['erro_login'] = "CPF ou Senha incorretos!";
    header("Location: login.php");
    exit;

} else {
    $_SESSION['erro_login'] = "Preencha todos os campos!";
    header("Location: login.php");
    exit;
}
?>