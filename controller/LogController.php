<?php
include_once 'model/UsuarioDAO.php';

class LogController
{

    //Metodo para ver la pantalla de log
    public function verLogin()
    {
        $view = 'view/log/login.php';
        include_once 'view/main.php';
    }

    //Metodo para procesar el Login y asi validar usuarios
    public function procesarLogin()
    {
        if (isset($_POST['email']) && isset($_POST['contraseña'])) {
            $email = $_POST['email'];
            $contraseña = $_POST['contraseña'];

            //Validar contra la base de datos
            $usuario = UsuarioDAO::validarUsuario($email, $contraseña);

            if ($usuario) {
                //Redireccion a Home
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php?controller=Home&action=verHome');
                exit;
            } else {
                // Login incorrecto
                $error = "Usuario o contraseña incorrectos";
                $view = 'view/log/login.php';
                include_once 'view/main.php';
            }
        } else {
            $error = "Por favor, completa todos los campos";
            $view = 'view/log/login.php';
            include_once 'view/main.php';
        }
    }
}
