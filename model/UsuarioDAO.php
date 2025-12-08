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

    //Funcion para registrar usuarios
    public static function registrarusuarios($nombre, $email, $contraseña, $direccion = null, $telefono = null, $rol = 'user'){
        $con = Database::connect();

        //Verificamos si el email ya existe
        $stmt = $con->prepare("SELECT id_usuario FROM usuario WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $con->close();
            return false; //Ya existe el email
        }

        //Hasheamos la contraseña
        $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

        //Insertamos nuevo usuario
        $stmt = $con->prepare("INSERT INTO usuario(nombre, email, contraseña, direccion, telefono, rol) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt-> bind_param('ssssss', $nombre, $email, $contraseña_hash, $direccion, $telefono, $rol);
        $exito = $stmt->execute();

        $con->close();
        return $exito;
    }
}
