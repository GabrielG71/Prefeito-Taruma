<?php 
session_start();

if(isset($_POST['cpf']) && !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])){
    require 'connection.php';
    require 'Usuario.Class.php';

    $u = new Usuario();
    
    $cpf = addslashes($_POST['cpf']);
    $senha = addslashes($_POST['senha']);

    if($u->login($cpf, $senha) == true){
        if(isset($_SESSION['idu'])){    
            header("Location: menu.php");
        } else {
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }

} else {
    header("Location: login.php");
}

?>