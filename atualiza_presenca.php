<?php 
// Inclui o script de verificação de login, garantindo que o usuário esteja autenticado
require 'verifica.php';

// Verifica se a requisição foi feita via POST e se há um usuário logado na sessão
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['idu'])) {
    // Obtém a data enviada pelo formulário, ou usa a data atual se não houver valor
    $dataSelecionada = $_POST['data'] ?? date('Y-m-d');

    // Percorre os dados de presenças enviados no formulário
    foreach ($_POST['presencas'] as $id => $presenca) {
        // Obtém a quantidade de faltas para o mesmo ID, ou define como 0 se não vier valor
        $falta = $_POST['faltas'][$id] ?? 0;

        // Atualiza a tabela de presenças com os valores de presença e falta para o ID correspondente
        $sql = "UPDATE presencas SET presencas = :presenca, faltas = :falta WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':presenca' => $presenca,
            ':falta' => $falta,
            ':id' => $id
        ]);
    }

    // Atualiza a tabela de usuários com o total de presenças e faltas somadas para cada usuário
    $sql = "UPDATE usuarios u
            LEFT JOIN (
                SELECT iduser, SUM(presencas) AS total_presencas, SUM(faltas) AS total_faltas 
                FROM presencas GROUP BY iduser
            ) p ON u.iduser = p.iduser
            SET u.total_presencas = p.total_presencas, u.total_faltas = p.total_faltas";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Redireciona o usuário de volta para a página de presença, passando a data selecionada pela URL
    header("Location: menu_presencas.php?data=" . urlencode($dataSelecionada));
    exit;
} else {
    // Caso não seja uma requisição POST ou o usuário não esteja logado, redireciona para o menu
    header("Location: menu_presencas.php");
    exit;
}
?>

