<?php
require 'verifica.php';

if(isset($_SESSION['idu']) && !empty($_SESSION['idu'])):

    $iduser = $_SESSION['idu'];

    // Buscar total de presenças e faltas do usuário logado
    $sql = "SELECT SUM(presencas) AS total_presencas, SUM(faltas) AS total_faltas 
            FROM presencas WHERE iduser = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':iduser' => $iduser]);
    $dados_presenca = $stmt->fetch(PDO::FETCH_ASSOC);

    // Buscar locais de embarque e desembarque
    $sql = "SELECT local_embarque, local_desembarque FROM embarque_desembarque WHERE iduser = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':iduser' => $iduser]);
    $dados_embarque = $stmt->fetch(PDO::FETCH_ASSOC);
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
                <li><a href="#">
                    <img src="Imagens/user.png" alt="User Logo" id="user_logo">
                    <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; ?></a>
                </li>
            </ul>   
        </nav>
    </header>
    <main class="main-content">
        <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>

        <h2>Suas Presenças</h2>
        <table>
            <tr>
                <th>Presenças</th>
                <th>Faltas</th>
            </tr>
            <tr>
                <td><?= $dados_presenca['total_presencas'] ?? 0 ?></td>
                <td><?= $dados_presenca['total_faltas'] ?? 0 ?></td>
            </tr>
        </table>

        <h2>Local de Embarque e Desembarque</h2>
        <table>
            <tr>
                <th>Local de Embarque</th>
                <th>Local de Desembarque</th>
            </tr>
            <tr>
                <td><?= htmlspecialchars($dados_embarque['local_embarque'] ?? 'Não cadastrado') ?></td>
                <td><?= htmlspecialchars($dados_embarque['local_desembarque'] ?? 'Não cadastrado') ?></td>
            </tr>
        </table>
    </main>    
    <footer class="footer">
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
<?php else: header("Location: index.html"); exit; endif; ?>