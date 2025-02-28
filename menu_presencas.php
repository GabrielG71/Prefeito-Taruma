<?php
require 'verifica.php';

if (!isset($_SESSION['idu']) || empty($_SESSION['idu'])) {
    header("Location: index.html");
    exit;
}

$sql = "SELECT DISTINCT data FROM presencas ORDER BY data DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$datas_disponiveis = $stmt->fetchAll(PDO::FETCH_COLUMN);

$dataSelecionada = $_GET['data'] ?? ($datas_disponiveis[0] ?? date('Y-m-d'));

$sql = "SELECT u.nome, SUM(p.presencas) AS total_presencas, SUM(p.faltas) AS total_faltas 
        FROM usuarios u
        LEFT JOIN presencas p ON u.iduser = p.iduser
        WHERE u.admin = 0
        GROUP BY u.nome
        ORDER BY u.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$presencas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT p.id, u.nome, p.presencas, p.faltas 
        FROM presencas p
        JOIN usuarios u ON p.iduser = u.iduser
        WHERE u.admin = 0 AND p.data = :data
        ORDER BY u.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute([':data' => $dataSelecionada]);
$registros_diarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenças</title>
    <link rel="stylesheet" href="menu_presencas.css">
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
        <header>
            <h1>Registros Diários</h1>
        </header>
        <form method="GET" action="menu_presencas.php">
            <label for="data">Escolha a Data:</label>
            <select name="data" id="data">
                <?php foreach ($datas_disponiveis as $data): ?>
                    <option value="<?= $data ?>" <?= ($data == $dataSelecionada) ? 'selected' : '' ?>>
                        <?= date("d/m/Y", strtotime($data)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrar</button>
        </form>
        <form action="atualiza_presenca.php" method="post">
            <input type="hidden" name="data" value="<?= htmlspecialchars($dataSelecionada) ?>">
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Presenças</th>
                    <th>Faltas</th>
                </tr>
                <?php if (!empty($registros_diarios)): ?>
                    <?php foreach ($registros_diarios as $registro): ?>
                        <tr>
                            <td><?= htmlspecialchars($registro['nome']) ?></td>
                            <td>
                                <input type="number" name="presencas[<?= $registro['id'] ?>]" value="<?= $registro['presencas'] ?>" min="0">
                            </td>
                            <td>
                                <input type="number" name="faltas[<?= $registro['id'] ?>]" value="<?= $registro['faltas'] ?>" min="0">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Nenhum registro encontrado para essa data.</td>
                    </tr>
                <?php endif; ?>
            </table>
            <button type="submit">Salvar</button>
        </form>
        <div class="voltar_presenca">
            <a href="menu_admin.php">Voltar para a presença</a>
        </div>
    </main>
    <footer class="footer">
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>