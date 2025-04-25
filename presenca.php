<?php
// Inclui arquivo de verificação de autenticação
require 'verifica.php';

// Verifica se a requisição é POST e se usuário está autenticado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['idu'])) {
    // Obtém a data atual no formato YYYY-MM-DD
    $dataAtual = date('Y-m-d');

    // Percorre todos os nomes enviados pelo formulário
    foreach ($_POST['nomes'] as $iduser => $nome) {
        // Verifica se marcou presença (1 = presente, 0 = faltou)
        $presenca = isset($_POST['presenca'][$iduser]) ? 1 : 0;
        // Se presente, falta = 0, senão falta = 1
        $falta = $presenca ? 0 : 1;

        // Consulta se já existe registro para este usuário na data atual
        $sql = "SELECT id FROM presencas WHERE iduser = :iduser AND data = :data";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':iduser' => $iduser, ':data' => $dataAtual]);
        $registro = $stmt->fetch();

        // Se registro existir, atualiza
        if ($registro) {
            $sql = "UPDATE presencas SET presencas = presencas + :presenca, faltas = faltas + :falta WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':presenca' => $presenca, ':falta' => $falta, ':id' => $registro['id']]);
        } else {
            // Se não existir, insere novo registro
            $sql = "INSERT INTO presencas (iduser, data, presencas, faltas) VALUES (:iduser, :data, :presenca, :falta)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':iduser' => $iduser, ':data' => $dataAtual, ':presenca' => $presenca, ':falta' => $falta]);
        }
    }

    // Redireciona para página de presenças após processamento
    header("Location: menu_presencas.php");
    exit;
} else {
    // Se não for POST ou usuário não autenticado, redireciona para admin
    header("Location: menu_admin.php");
    exit;
}
?>
