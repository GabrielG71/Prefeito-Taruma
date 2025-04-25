<?php 
// Verifica se o usuário está logado
require 'verifica.php';

// Se o formulário foi enviado e o usuário está autenticado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['idu'])) {
    // Pega a data enviada ou usa a data atual como padrão
    $dataSelecionada = $_POST['data'] ?? date('Y-m-d');

    // Atualiza os dados de presença e falta para cada registro
    foreach ($_POST['presencas'] as $id => $presenca) {
        $falta = $_POST['faltas'][$id] ?? 0;

        $sql = "UPDATE presencas SET presencas = :presenca, faltas = :falta WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':presenca' => $presenca,
            ':falta' => $falta,
            ':id' => $id
        ]);
    }

    // Atualiza os totais de presenças e faltas na tabela de usuários
    $sql = "UPDATE usuarios u
            LEFT JOIN (
                SELECT iduser, SUM(presencas) AS total_presencas, SUM(faltas) AS total_faltas 
                FROM presencas GROUP BY iduser
            ) p ON u.iduser = p.iduser
            SET u.total_presencas = p.total_presencas, u.total_faltas = p.total_faltas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Redireciona para o menu com a data selecionada
    header("Location: menu_presencas.php?data=" . urlencode($dataSelecionada));
    exit;
} else {
    // Se não for POST ou não estiver logado, volta para o menu
    header("Location: menu_presencas.php");
    exit;
}
?>
