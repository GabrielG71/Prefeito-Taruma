<?php
// Verifica se o usuário está logado
require 'verifica.php';

// Busca todos usuários cadastrados para preencher o dropdown
$sql = $pdo->query("SELECT iduser, nome FROM usuarios ORDER BY nome ASC");
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);

// Verifica se foi solicitada a edição de um usuário
$editando = false;
$usuario = [];
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $editando = true;
    $id = (int)$_GET['id']; // Converte para inteiro por segurança

    // Busca dados completos do usuário (incluindo locais de embarque)
    $sql = $pdo->prepare("SELECT u.*, e.local_embarque, e.local_desembarque 
                        FROM usuarios u 
                        LEFT JOIN embarque_desembarque e ON u.iduser = e.iduser
                        WHERE u.iduser = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    $usuario = $sql->fetch(PDO::FETCH_ASSOC); // Pega apenas 1 registro
}
?>

<!-- Formulário de Cadastro -->
<h2>Cadastrar Novo Usuário</h2>
<form action="cadastrar.php" method="POST">
    <!-- Campos básicos do usuário -->
    <label for="nome">Nome:</label>
    <input type="text" name="nome" required>

    <label for="cpf">CPF:</label>
    <input type="text" name="cpf" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" required>

    <!-- Dropdown de situação -->
    <label for="sit">Situação:</label>
    <select name="sit" required>
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
    </select>

    <!-- Nível de acesso -->
    <label for="admin">Admin:</label>
    <select name="admin" required>
        <option value="0">Usuário Comum</option>
        <option value="1">Administrador</option>
    </select>

    <!-- Locais de embarque/desembarque -->
    <label for="local_embarque">Local de Embarque:</label>
    <input type="text" name="local_embarque" required>

    <label for="local_desembarque">Local de Desembarque:</label>
    <input type="text" name="local_desembarque" required>

    <button type="submit">Cadastrar</button>
</form>

<hr>

<!-- Seletor de Usuário para Edição -->
<h2>Editar Usuário Existente</h2>
<form method="GET" action="cadastro.php">
    <label for="id">Selecionar Usuário:</label>
    <select name="id" required>
        <option value="">Selecione um usuário</option>
        <!-- Preenche dropdown com usuários do banco -->
        <?php foreach ($usuarios as $u): ?>
            <option value="<?php echo $u['iduser']; ?>" 
                <?php echo ($editando && $usuario['iduser'] == $u['iduser']) ? 'selected' : ''; ?>>
                <?php echo $u['nome']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filtrar</button>
</form>

<!-- Formulário de Edição (só aparece quando um usuário é selecionado) -->
<?php if ($editando): ?>
    <h3>Editar Usuário</h3>
    <form action="cadastrar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $usuario['iduser']; ?>">

        <!-- Campos pré-preenchidos com os dados do usuário -->
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" value="<?php echo $usuario['cpf']; ?>" readonly>

        <!-- Dropdowns com seleção atual -->
        <label for="sit">Situação:</label>
        <select name="sit" required>
            <option value="ativo" <?php echo $usuario['sit'] == 'ativo' ? 'selected' : ''; ?>>Ativo</option>
            <option value="inativo" <?php echo $usuario['sit'] == 'inativo' ? 'selected' : ''; ?>>Inativo</option>
        </select>

        <label for="admin">Admin:</label>
        <select name="admin" required>
            <option value="0" <?php echo $usuario['admin'] == 0 ? 'selected' : ''; ?>>Usuário Comum</option>
            <option value="1" <?php echo $usuario['admin'] == 1 ? 'selected' : ''; ?>>Administrador</option>
        </select>

        <!-- Locais de embarque -->
        <label for="local_embarque">Local de Embarque:</label>
        <input type="text" name="local_embarque" value="<?php echo $usuario['local_embarque']; ?>" required>

        <label for="local_desembarque">Local de Desembarque:</label>
        <input type="text" name="local_desembarque" value="<?php echo $usuario['local_desembarque']; ?>" required>

        <button type="submit">Salvar Alterações</button>
    </form>
<?php endif; ?>
