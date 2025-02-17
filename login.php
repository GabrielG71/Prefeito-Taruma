<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script defer src="app_login.js"></script>
</head>
<body>
<header class="container1">
        <nav class="container-box">
            <div class="prefeitura-img">
                <div class="image-container"><a href="#" id="logo_prefeitura"><img src="Imagens/logo-tarumã.png" alt=""></a></div>
                <div class="marca-container"><a href="#" id="marca_prefeitura"><img src="Imagens/marca_prefeitura.png" alt=""></a></div>
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
            <h2 id="login">Login</h2>
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
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
