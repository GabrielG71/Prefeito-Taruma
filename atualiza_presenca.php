<?php
require 'verifica.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['idu'])) {
    $dataSelecionada = $_POST['data'] ?? date('Y-m-d');

    foreach ($_POST['presencas'] as $id => $presenca) {
        $falta = $_POST['faltas'][$id] ?? 0;

        $sql = "UPDATE presencas SET presencas = :presenca, faltas = :falta WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':presenca' => $presenca, ':falta' => $falta, ':id' => $id]);
    }

    $sql = "UPDATE usuarios u
            LEFT JOIN (
                SELECT iduser, SUM(presencas) AS total_presencas, SUM(faltas) AS total_faltas 
                FROM presencas GROUP BY iduser
            ) p ON u.iduser = p.iduser
            SET u.total_presencas = p.total_presencas, u.total_faltas = p.total_faltas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    header("Location: menu_presencas.php?data=" . urlencode($dataSelecionada));
    exit;
} else {
    header("Location: menu_presencas.php");
    exit;
}
?>