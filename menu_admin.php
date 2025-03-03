<?php
require 'verifica.php';

if (isset($_SESSION['idu']) && !empty($_SESSION['idu'])):
    $sql = "SELECT iduser, nome FROM usuarios WHERE admin = 0";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="menu_admin.css">
    <script defer src="app_menu.js"></script>
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
                <li><a href="logout.php">DESLOGAR</a></li>
                <li><a href="#">
                    <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; ?></a>
                </li>
            </ul>   
        </nav>
    </header>
    <main class="main-content">
    
    <form action="presenca.php" method="post">
    <h2>Lista de Presença</h2>
        <h3><?php 
        $data = new IntlDateFormatter(
            'pt_BR', 
            IntlDateFormatter::FULL, 
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN,
            "EEEE, d 'de' MMMM 'de' yyyy"
        );
        echo $data->format(new DateTime());
        ?></h3>
        <table class="table table-striped table-hover" id="presença">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Presença</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['nome']) ?></td>
                            <td>
                                <input type="checkbox" name="presenca[<?= $usuario['iduser'] ?>]" value="1" class="form-check-input mt-0">
                                <input type="hidden" name="nomes[<?= $usuario['iduser'] ?>]" value="<?= htmlspecialchars($usuario['nome']) ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">Nenhum usuário cadastrado</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-outline-primary" id="btn_salve">Enviar</button>
        <a href="menu_presencas.php" class="btn btn-outline-primary" id="btn_salve">Ver as presenças</a>
    </form>
    
        
   
    </main>    
    <footer class="footer">
        <p>&copy; 2024 Prefeitura de Tarumã. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
<?php else: header("Location: index.html"); endif;?>