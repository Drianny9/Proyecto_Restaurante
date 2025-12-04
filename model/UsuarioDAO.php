<?php
include_once 'model/Usuario.php';
include_once 'database/database.php';


class UsuarioDAO{

    public static function getUsuarioById($id_usuario)
    {
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param('i', $id_usuario); //La 'i' indica el tipo de dato (integer)
        $stmt->execute();
        $results = $stmt->get_result();

        $equipo = $results->fetch_object('Usuario');
        $con->close();

        return $equipo;
    }

    public static function getUsuarios()
    {
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM usuario");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaUsuarios = [];
        while ($usuario = $results->fetch_object('Usuario')) {
            $listaUsuarios[] = $usuario;
        }

        $con->close();
        return $listaUsuarios;
    }

    public static function validarUsuario($email, $contraseña)
    {
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_object('Usuario');

            //Verifica la contraseña (si está hasheada/encriptada)
            if (password_verify($contraseña, $usuario->getContraseña())) {
                $con->close();  
                return $usuario; //Login correcto
            }
        }

        $con->close();
        return null; //Login incorrecto
    }
}
