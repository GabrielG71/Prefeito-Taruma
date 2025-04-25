<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Configurações básicas do documento -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura viewport para responsividade -->
    <title>Login</title> <!-- Título da página exibido na aba do navegador -->
    
    <!-- Inclusão de frameworks e estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> <!-- Framework Bootstrap CSS -->
    <link rel="stylesheet" href="login.css"> <!-- Folha de estilos personalizada -->
    <script defer src="app_login.js"></script> <!-- JavaScript com defer para carregar após o HTML -->
</head>
<body>
    <!-- Cabeçalho da página -->
    <header class="container1">
        <nav class="container-box">
            <!-- Logo da Prefeitura -->
            <div class="prefeitura-img">
                <div class="image-container">
                    <a href="#" id="logo_prefeitura">
                        <img src="Imagens/logo-tarumã.png" alt="Logo da Prefeitura de Tarumã">
                    </a>
                </div>
            </div>
            
            <!-- Botão do menu hamburguer (para mobile) -->
            <button class="hamburguer"></button>
            
            <!-- Menu de navegação principal -->
            <ul class="nav-list">
                <li><a href="index.html">HOME</a></li> <!-- Link para página inicial -->
                <li><a href="contato.html">CONTATO</a></li> <!-- Link para página de contato -->
            </ul>   
        </nav>
    </header>

    <!-- Conteúdo principal da página -->
    <main>
        <!-- Container do formulário de login -->
        <div class="login-container">
            <h2 id="login">LOGIN</h2> <!-- Título da seção -->
            
            <!-- Exibição de mensagens de erro (PHP) -->
            <?php
            session_start(); // Inicia a sessão para acessar variáveis de sessão
            if(isset($_SESSION['erro_login'])) { // Verifica se há mensagem de erro
                echo "<p class='erro'>".$_SESSION['erro_login']."</p>"; // Exibe a mensagem
                unset($_SESSION['erro_login']); // Remove a mensagem após exibir
            }
            ?>
            
            <!-- Formulário de login -->
            <form action="logar.php" method="POST"> <!-- Envia dados para logar.php via POST -->
                <div class="input-group">
                    <label for="cpf">CPF:</label>
                    <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" required> <!-- Campo obrigatório -->
                </div>
                <div class="input-group">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required> <!-- Campo obrigatório -->
                </div>
                <button type="submit" class="btn btn-outline-info btn-login">Logar</button> <!-- Botão de submit -->
                <a href="#" class="link-esqueci-senha">Esqueceu a senha?</a> <!-- Link para recuperação de senha -->
            </form>
        </div>
    </main>

    <!-- Rodapé da página -->
    <footer class="footer">
        <div class="container">
            <!-- Coluna com informações institucionais -->
            <div class="col">
                <h5>AETA</h5>
                <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
                <p>CNPJ: 03.148.712/0001-40</p>
            </div>
            
            <!-- Coluna com informações de contato -->
            <div class="col">
                <h5>Contato</h5>
                <p>&#128231; E-mail: aetataruma@gmail.com</p>
                <p>&#128205; Rua Jasmin 296, Centro - Tarumã</p>
                <p>&#128222; (18) 99646-4673</p>
            </div>
            
            <!-- Coluna com links de navegação -->
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
