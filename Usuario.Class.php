<?php 

class Usuario{

    public function login($cpf, $senha){
        global $pdo;

        $sql = "SELECT * FROM usuarios WHERE cpf = :cpf and pass = :senha";
        $sql = $pdo->prepare($sql);
        $sql->bindValue('cpf', $cpf);
        $sql->bindValue('senha', md5($senha));
        $sql->execute();

        if($sql->rowCount() > 0){
            $dado = $sql->fetch();

            $_SESSION['idu'] = $dado['iduser'];

            return true;
        }else{
           return false; 
        }
        }
    }
?>