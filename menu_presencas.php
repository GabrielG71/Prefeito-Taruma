<?php
// Verifica se o usuário está autenticado (arquivo que contém a verificação)
require 'verifica.php';

// Se não houver ID de usuário na sessão, redireciona para a página inicial
if (!isset($_SESSION['idu']) || empty($_SESSION['idu'])) {
    header("Location: index.html");
    exit; // Termina a execução do script
}

// Busca todas as datas distintas com registros de presença, ordenadas da mais recente para a mais antiga
$sql = "SELECT DISTINCT data FROM presencas ORDER BY data DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$datas_disponiveis = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Define a data selecionada: pega da URL, senão usa a mais recente disponível, senão usa a data atual
$dataSelecionada = $_GET['data'] ?? ($datas_disponiveis[0] ?? date('Y-m-d'));

// Consulta para obter o somatório de presenças e faltas de todos os usuários não-administradores
$sql = "SELECT u.nome, SUM(p.presencas) AS total_presencas, SUM(p.faltas) AS total_faltas 
        FROM usuarios u
        LEFT JOIN presencas p ON u.iduser = p.iduser
        WHERE u.admin = 0
        GROUP BY u.nome
        ORDER BY u.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$presencas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obter os registros diários específicos para a data selecionada
$sql = "SELECT p.id, u.nome, p.presencas, p.faltas 
        FROM presencas p
        JOIN usuarios u ON p.iduser = u.iduser
        WHERE u.admin = 0 AND p.data = :data
        ORDER BY u.nome";
$stmt = $pdo->prepare($sql);
$stmt->execute([':data' => $dataSelecionada]);
$registros_diarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- A partir daqui é HTML puro com alguns trechos PHP para exibir dados dinâmicos -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Metadados básicos -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presenças</title>
    
    <!-- Framework Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- Folha de estilos personalizada -->
    <link rel="stylesheet" href="menu_presencas.css">
    
    <!-- JavaScript (carregado ao final da página) -->
    <script defer src="app_menu.js"></script>
</head>
<body>
<!-- Cabeçalho da página -->
<header class="container1">
        <nav class="container-box">
            <!-- Logo da prefeitura -->
            <div class="prefeitura-img">
                <div class="image-container"><a href="#" id="logo_prefeitura"><img src="Imagens/logo-tarumã.png" alt=""></a></div>
            </div>
            <!-- Botão do menu hamburguer (para mobile) -->
            <button class="hamburguer"></button>
            <!-- Menu de navegação -->
            <ul class="nav-list">
                <li><a href="logout.php">DESLOGAR</a></li>
                <li><a href="#">
                    <!-- Exibe o nome do usuário logado ou 'Usuário' como fallback -->
                    <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; ?></a>
                </li>
            </ul>   
        </nav>
    </header>
    
    <!-- Conteúdo principal da página -->
    <main>
        <!-- Tabela de totais de presença -->
        <h1>Presenças Total</h1>
        <table class="table table-striped table-hover" id="presença">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Presenças</th>
                    <th>Faltas</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop para exibir cada usuário e seus totais -->
                <?php foreach ($presencas as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td><?= $p['total_presencas'] ?? 0 ?></td>
                        <td><?= $p['total_faltas'] ?? 0 ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <!-- Seção de registros diários -->
        <h1>Registros Diários</h1>
        
        <!-- Formulário para filtrar por data -->
        <form method="GET" action="menu_presencas.php">
            <label for="data" id="label">Escolha a Data:</label>
            <select name="data" id="data" class="form-select">
                <!-- Loop para exibir cada data disponível -->
                <?php foreach ($datas_disponiveis as $data): ?>
                    <option value="<?= $data ?>" <?= ($data == $dataSelecionada) ? 'selected' : '' ?>>
                        <!-- Formata a data para exibição amigável -->
                        <?= date("d/m/Y", strtotime($data)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-outline-primary" id="btn_filt">Filtrar</button>
        </form>
        
        <!-- Formulário para atualizar presenças/faltas -->
        <form action="atualiza_presenca.php" method="post">
            <!-- Campo oculto para enviar a data selecionada -->
            <input type="hidden" name="data" value="<?= htmlspecialchars($dataSelecionada) ?>">
            
            <!-- Tabela de registros diários -->
            <table class="table table-striped table-hover" id="presença2">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Presenças</th>
                        <th>Faltas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($registros_diarios)): ?>
                        <!-- Loop para exibir cada registro diário -->
                        <?php foreach ($registros_diarios as $registro): ?>
                            <tr>
                                <td><?= htmlspecialchars($registro['nome']) ?></td>
                                <!-- Campos editáveis para presenças e faltas -->
                                <td>
                                    <input type="number" class="form-control" name="presencas[<?= $registro['id'] ?>]" value="<?= $registro['presencas'] ?>" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="faltas[<?= $registro['id'] ?>]" value="<?= $registro['faltas'] ?>" min="0">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <!-- Mensagem caso não haja registros -->
                        <tr>
                            <td colspan="3">Nenhum registro encontrado para essa data.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <!-- Botões de ação -->
            <button type="submit" class="btn btn-outline-primary" id="save">Salvar</button>
            <a href="menu_admin.php" class="btn btn-outline-primary">Voltar para a presença</a>
        </form>
    </main>
    
    <!-- Rodapé da página -->
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
