<?php
require 'verifica.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['idu'])) {
    $dataAtual = date('Y-m-d');

    foreach ($_POST['nomes'] as $iduser => $nome) {
        $presenca = isset($_POST['presenca'][$iduser]) ? 1 : 0;
        $falta = $presenca ? 0 : 1;

        $sql = "SELECT id FROM presencas WHERE iduser = :iduser AND data = :data";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':iduser' => $iduser, ':data' => $dataAtual]);
        $registro = $stmt->fetch();

        if ($registro) {
            $sql = "UPDATE presencas SET presencas = presencas + :presenca, faltas = faltas + :falta WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':presenca' => $presenca, ':falta' => $falta, ':id' => $registro['id']]);
        } else {
            $sql = "INSERT INTO presencas (iduser, data, presencas, faltas) VALUES (:iduser, :data, :presenca, :falta)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':iduser' => $iduser, ':data' => $dataAtual, ':presenca' => $presenca, ':falta' => $falta]);
        }
    }

    header("Location: menu_presencas.php");
    exit;
} else {
    header("Location: menu_admin.php");
    exit;
}
?>
