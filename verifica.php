<?php 

require 'connection.php';

if(isset($_SESSION['idu']) && !empty($_SESSION['idu'])){
    
    require_once 'Usuario.Class.php';
    $u = new Usuario();

    $listLogged = $u->logged($_SESSION['idu']);

    echo $listLogged['nome'];

}else{
    header("Location: index.html");
}

?>