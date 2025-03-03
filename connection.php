<?php 

$localhost = "localhost:3312";
$user = "root";
$passw = "";
$banco = "transporte";

global $pdo;

try{
    $pdo = new PDO("mysql:host=$localhost;dbname=$banco", $user, $passw);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo"ERRO: ".$e->getMessage();
    exit;
}



?>