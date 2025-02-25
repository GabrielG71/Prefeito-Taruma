<?php
require 'verifica.php';

if (isset($_SESSION['idu']) && !empty($_SESSION['idu'])):
    $sql = "SELECT iduser, nome FROM usuarios";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <h1>Admin</h1>
        <h2>Lista de Presença</h2>
        <table border="1">
            <tr>
                <th>Nome</th>
                <th>Presença</th>
            </tr>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= htmlspecialchars($usuario['nome']) ?></td>
                        <td><input type="checkbox"></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2">Nenhum usuário cadastrado</td></tr>
            <?php endif; ?>
        </table>
    </main>    
    <footer class="footer">
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
<?php else: header("Location: index.html"); endif;?>