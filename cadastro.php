<?php
$ips_permitidos = ['127.0.0.1', '::1'];

if (!in_array($_SERVER['REMOTE_ADDR'], $ips_permitidos)) {
    http_response_code(403);
    exit("Acesso negado.");
}
?>
<form action="cadastrar.php" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" required>

    <label for="cpf">CPF:</label>
    <input type="text" name="cpf" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" required>

    <label for="sit">Situação:</label>
    <select name="sit" required>
        <option value="ativo">Ativo</option>
        <option value="inativo">Inativo</option>
    </select>

    <label for="admin">Admin:</label>
    <select name="admin" required>
        <option value="0">Usuário Comum</option>
        <option value="1">Administrador</option>
    </select>

    <button type="submit">Cadastrar</button>
</form>