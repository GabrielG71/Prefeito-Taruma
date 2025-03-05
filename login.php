<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <script defer src="app_login.js"></script>
</head>
<body>
<header class="container1">
        <nav class="container-box">
            <div class="prefeitura-img">
                <div class="image-container"><a href="#" id="logo_prefeitura"><img src="Imagens/logo-tarumã.png" alt=""></a></div>
            </div>
            <button class="hamburguer"></button>
            <ul class="nav-list">
                <li><a href="index.html">HOME</a></li>
                <li><a href="contato.html">CONTATO</a></li>
            </ul>   
        </nav>
    </header>

    <main>
        <div class="login-container">
            <h2 id="login">LOGIN</h2>
            <?php
            session_start();
            if(isset($_SESSION['erro_login'])) {
            echo "<p class='erro'>".$_SESSION['erro_login']."</p>";
            unset($_SESSION['erro_login']);
            }
            ?>
            <form action="logar.php" method="POST">
                <div class="input-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required>
                </div>
                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="btn-login">Logar</button>
                <a href="#" class="link-esqueci-senha">Esqueceu a senha?</a>
            </form>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="col">
                <h5>AETA</h5>
                <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
                <p>CNPJ: 03.148.712/0001-40</p>
            </div>
            <div class="col">
                <h5>Contato</h5>
                <p>&#128231; E-mail: aetataruma@gmail.com</p>
                <p>&#128205; Rua Jasmin 296, Centro - Tarumã</p>
                <p>&#128222; (18) 99646-4673</p>
            </div>
            <div class="col footer-links">
                <h5>Navegação</h5>
                <a href="index.html">Home</a>
                <a href="contato.html">Contato</a>
                <a href="login.php">Login</a>
            </div>
        </div>
    </footer>
</body>
</html>
