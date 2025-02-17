<?php
session_start();
require 'verifica.php';

if(isset($_SESSION['idu']) && !empty($_SESSION['idu'])):
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prefeitura Tarumã</title>
    <link rel="stylesheet" href="menu.css">
    <script defer src="app_menu.js"></script>
</head>
<body>
    <header class="header">
        <nav class="nav">
            <div class="prefeitura">
                <a href="#" id="logo_prefeitura"><li><img src="Imagens/logo-tarumã.png" alt=""></li></a>
                <a href="#" id="marca_prefeitura"><li><img src="Imagens/marca_prefeitura.png" alt=""></li></a>
            </div>
            <button class="hamburguer"></button>
            <ul class="nav-list">
                <li><a href="logout.php">DESLOGAR</a></li>
            </ul>   
        </nav>
    </header>
    <main class="main-content">
    
    </main>    
    <footer class="footer">
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
<?php else: header("Location: index.html"); endif;?>