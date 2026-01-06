<?php
include_once 'model/UsuarioDAO.php';
include_once 'model/LogDAO.php';

class LogController
{

    //Metodo para ver la pantalla de log
    public function verLogin()
    {
        // Login tiene su propia estructura HTML, no usa main.php
        include_once 'view/log/login.php';
    }

    //Metodo para procesar el Login y asi validar usuarios
    public function procesarLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Validar contra la base de datos
            $usuario = UsuarioDAO::validarUsuario($email, $password);

            if ($usuario) {
                //Registrar log de login exitoso
                $accion = "LOGIN_EXITO: Usuario {$usuario->getEmail()} inició sesión";
                LogDAO::crearLog($accion, $usuario->getId_usuario());
                
                //Redireccion a Home
                $_SESSION['usuario'] = $usuario;
                header('Location: index.php?controller=Home&action=verHome');
                exit;
            } else {
                // Registrar log de login fallido
                $accion = "LOGIN_FALLIDO: Intento fallido con email {$email}";
                LogDAO::crearLog($accion);
                
                // Login incorrecto
                $error = "Usuario o contraseña incorrectos";
                include_once 'view/log/login.php';
            }
        } else {
            $error = "Por favor, completa todos los campos";
            include_once 'view/log/login.php';
        }
    }

    //Metodo para cerrar sesion
    public function cerrarSesion()
    {
        // Registrar log de cierre de sesión
        if (isset($_SESSION['usuario'])) {
            $email = $_SESSION['usuario']->getEmail();
            $id_usuario = $_SESSION['usuario']->getId_usuario();
            $accion = "LOGOUT: Usuario {$email} cerró sesión";
            LogDAO::crearLog($accion, $id_usuario);
        }
        
        // Destruir todas las variables de sesión
        session_unset();
        
        // Destruir la sesión
        session_destroy();
        
        // Redirigir al home
        header('Location: index.php?controller=Home&action=verHome');
        exit;
    }
}
