<?php 
session_start();
unset($_SESSION['idu']);

header("Location: index.html");

?>