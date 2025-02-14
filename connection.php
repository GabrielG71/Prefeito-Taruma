<?php 

$localhost = "localhost:8080";
$user = "root";
$passw = "";
$banco = "transporte";

$connect = mysqli_connect($localhost, $user, $passw, $banco);

$sql = mysqli_query($connect, "SELECT * FROM usuarios");

echo mysqli_num_rows($sql);

?>