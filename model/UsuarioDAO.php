<?php
include_once __DIR__ . '/Usuario.php';
include_once __DIR__ . '/../database/database.php';

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

    public static function validarUsuario($email, $password)
    {
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM usuario WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuario = $result->fetch_object('Usuario');

            //Recibe la contraseña escrita por usuario y el hash guardado en la BD y devuelve true o false cuando calcula el hash
            if (password_verify($password, $usuario->getPassword())) {
                $con->close();
                return $usuario; //Login correcto
            }
        }

        $con->close();
        return null; //Login incorrecto
    }

    //Funcion para registrar usuarios
    public static function registrarusuarios($nombre, $email, $password, $direccion = null, $telefono = null, $rol = 'user'){
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

        //El metodo recibe una texto plano y lo convierte a una cadena
        $password_hash = password_hash($password, PASSWORD_DEFAULT); //PASSWORD_DEFAULT es para que php use el algoritmo más fuerte que tiene instalado

        //Insertamos nuevo usuario
        $stmt = $con->prepare("INSERT INTO usuario(nombre, email, password, direccion, telefono, rol) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt-> bind_param('ssssss', $nombre, $email, $password_hash, $direccion, $telefono, $rol);
        $exito = $stmt->execute();

        $con->close();
        return $exito;
    }

    // Actualizar usuario
    public static function actualizarUsuario($id_usuario, $nombre, $email, $direccion, $telefono, $rol) {
        $con = Database::connect();
        $stmt = $con->prepare("UPDATE usuario SET nombre = ?, email = ?, direccion = ?, telefono = ?, rol = ? WHERE id_usuario = ?");
        $stmt->bind_param('sssssi', $nombre, $email, $direccion, $telefono, $rol, $id_usuario);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }

    // Eliminar usuario
    public static function eliminarUsuario($id_usuario) {
        $con = Database::connect();
        $stmt = $con->prepare("DELETE FROM usuario WHERE id_usuario = ?");
        $stmt->bind_param('i', $id_usuario);
        $results = $stmt->execute();
        $con->close();
        return $results;
    }
}
