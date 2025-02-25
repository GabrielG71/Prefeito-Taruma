<?php 
class Usuario {

    public function login($cpf, $senha) {
        global $pdo;

        $sql = "SELECT iduser, admin, pass FROM usuarios WHERE cpf = :cpf";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':cpf', $cpf);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $dado = $sql->fetch();

            if (password_verify($senha, $dado['pass'])) {
                $_SESSION['idu'] = $dado['iduser'];
                $_SESSION['admin'] = $dado['admin'];
                return true;
            }
        }

        return false;
    }

    public function logged($id) {
        global $pdo;

        $array = array();

        $sql = "SELECT nome FROM usuarios WHERE iduser = :iduser";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":iduser", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }

        return $array;
    }
}
?>