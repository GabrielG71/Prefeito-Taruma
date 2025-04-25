<?php
// Verifica se o usuário está logado
require 'verifica.php';

// Se o usuário estiver autenticado (com ID na sessão)
if(isset($_SESSION['idu']) && !empty($_SESSION['idu'])):

    // Obtém o ID do usuário da sessão
    $iduser = $_SESSION['idu'];

    // Consulta 1: Busca o total de presenças e faltas do usuário
    $sql = "SELECT SUM(presencas) AS total_presencas, SUM(faltas) AS total_faltas 
            FROM presencas WHERE iduser = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':iduser' => $iduser]);
    $dados_presenca = $stmt->fetch(PDO::FETCH_ASSOC);

    // Consulta 2: Busca os locais de embarque/desembarque do usuário
    $sql = "SELECT local_embarque, local_desembarque FROM embarque_desembarque WHERE iduser = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':iduser' => $iduser]);
    $dados_embarque = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prefeitura Tarumã</title>
    <!-- Framework Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="menu.css">
    <!-- JavaScript (carregado ao final) -->
    <script defer src="app_menu.js"></script>
</head>
<body>
    <!-- Cabeçalho da página -->
    <header class="container1">
        <nav class="container-box">
            <!-- Logo da Prefeitura -->
            <div class="prefeitura-img">
                <div class="image-container">
                    <a href="#" id="logo_prefeitura">
                        <img src="Imagens/logo-tarumã.png" alt="Logo da Prefeitura">
                    </a>
                </div>
            </div>
            <!-- Menu Hamburguer (mobile) -->
            <button class="hamburguer"></button>
            <!-- Menu de navegação -->
            <ul class="nav-list">
                <li><a href="logout.php">DESLOGAR</a></li> <!-- Link para logout -->
                <li><a href="#">
                    <!-- Exibe o nome do usuário ou 'Usuário' como fallback -->
                    <?php echo isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : 'Usuário'; ?>
                </a></li>
            </ul>   
        </nav>
    </header>

    <!-- Conteúdo principal -->
    <main class="main-content">
        <!-- Saudação personalizada -->
        <h1 id="h1s">Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>

        <!-- Tabela de presenças/faltas -->
        <h2>Suas Presenças</h2>
        <table class="table table-striped" id="presença">
            <thead>
                <tr>
                    <th>Presenças</th>
                    <th>Faltas</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Exibe totais (com fallback para 0 se não existir) -->
                    <td><?= $dados_presenca['total_presencas'] ?? 0 ?></td>
                    <td><?= $dados_presenca['total_faltas'] ?? 0 ?></td>
                </tr>
            </tbody>
        </table>

        <!-- Tabela de locais -->
        <table class="table table-striped" id="presença">
            <thead>
                <tr>
                    <th>Local de Embarque</th>
                    <th>Local de Desembarque</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Exibe locais com tratamento contra XSS e fallback -->
                    <td><?= htmlspecialchars($dados_embarque['local_embarque'] ?? 'Não cadastrado') ?></td>
                    <td><?= htmlspecialchars($dados_embarque['local_desembarque'] ?? 'Não cadastrado') ?></td>
                </tr>
            </tbody>
        </table>
    </main>    

    <!-- Rodapé da página -->
    <footer class="footer">
        <div class="container">
            <!-- Informações institucionais -->
            <div class="col">
                <h5>AETA</h5>
                <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
                <p>CNPJ: 03.148.712/0001-40</p>
            </div>
            <!-- Informações de contato -->
            <div class="col">
                <h5>Contato</h5>
                <p>&#128231; E-mail: aetataruma@gmail.com</p>
                <p>&#128205; Rua Jasmin 296, Centro - Tarumã</p>
                <p>&#128222; (18) 99646-4673</p>
            </div>
            <!-- Links de navegação -->
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
<?php else: 
    // Se o usuário não estiver logado, redireciona para a página inicial
    header("Location: index.html"); 
    exit; 
endif; 
?>
