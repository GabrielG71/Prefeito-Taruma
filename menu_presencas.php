<?php
require 'verifica.php';

if (!isset($_SESSION['idu']) || empty($_SESSION['idu'])) {
    header("Location: index.html");
    exit;
}

$sql = "SELECT u.nome, SUM(p.presencas) AS total_presencas, SUM(p.faltas) AS total_faltas 
        FROM usuarios u
        LEFT JOIN presencas p ON u.iduser = p.iduser
        WHERE u.admin = 0
        GROUP BY u.nome
        ORDER BY u.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$presencas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenças</title>
    <link rel="stylesheet" href="menu_presencas.css">
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
    <main>
        <h1>Presenças Total</h1>
        <table>
            <tr>
                <th>Nome</th>
                <th>Presenças</th>
                <th>Faltas</th>
            </tr>
            <?php foreach ($presencas as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= $p['total_presencas'] ?? 0 ?></td>
                    <td><?= $p['total_faltas'] ?? 0 ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
