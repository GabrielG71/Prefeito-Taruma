<?php 
// Declara a classe Usuario
class Usuario {

    // Função para realizar o login com CPF e senha
    public function login($cpf, $senha) {
        global $pdo; // Usa a variável global $pdo para acesso ao banco de dados

        // Prepara a consulta SQL para buscar o usuário com o CPF informado
        $sql = "SELECT iduser, admin, pass FROM usuarios WHERE cpf = :cpf";
        $sql = $pdo->prepare($sql); // Prepara a query SQL para execução
        $sql->bindValue(':cpf', $cpf); // Substitui o placeholder :cpf pelo valor do CPF informado
        $sql->execute(); // Executa a query

        // Verifica se algum usuário foi encontrado
        if ($sql->rowCount() > 0) {
            $dado = $sql->fetch(); // Obtém os dados do usuário encontrado

            // Verifica se a senha fornecida confere com a senha armazenada (criptografada)
            if (password_verify($senha, $dado['pass'])) {
                $_SESSION['idu'] = $dado['iduser']; // Armazena o ID do usuário na sessão
                $_SESSION['admin'] = $dado['admin']; // Armazena o status de admin na sessão
                return true; // Retorna true indicando que o login foi bem-sucedido
            }
        }

        return false; // Retorna false caso o login não seja bem-sucedido
    }

    // Função para verificar se o usuário está logado e retornar seu nome
    public function logged($id) {
        global $pdo; // Usa a variável global $pdo

        $array = array(); // Inicializa um array vazio para armazenar o resultado

        // Prepara a consulta SQL para buscar o nome do usuário com o ID fornecido
        $sql = "SELECT nome FROM usuarios WHERE iduser = :iduser";
        $sql = $pdo->prepare($sql); // Prepara a query
        $sql->bindValue(":iduser", $id); // Substitui o placeholder :iduser pelo valor do ID
        $sql->execute(); // Executa a query

        // Se encontrou algum resultado, armazena os dados no array
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(); // Obtém o nome do usuário
        }

        return $array; // Retorna o array com o nome do usuário (ou vazio se não encontrou)
    }
}
?>

?>
