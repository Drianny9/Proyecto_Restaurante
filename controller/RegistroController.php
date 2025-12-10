<?php
include_once 'model/UsuarioDAO.php';

    class RegistroController{
        //Funcion para ver la pagina de registro
        public function verRegistro(){
            $view = 'view/log/registro.php';
            include_once 'view/main.php';
        }

        //funcion para procesar los registros
        public function procesarRegistro(){
            //Comprobamos que existe nombre, email y contraseña y le asignamos lo que se pone en el formulario
            if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['contraseña'])) {
                $nombre = trim($_POST['nombre']);
                $email = trim($_POST['email']);
                $contraseña = $_POST['contraseña'];
                $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : null;
                $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;

                //Verificamos que ninguna casilla este vacia
                if (empty($nombre) || empty($email) ||empty($contraseña)) {
                    $error = "Por favor, complea todos los campos obligatorios.";
                    $view = 'view/log/registro.php';
                    include_once 'view/main.php';
                    return;
                }

                //Con filter_var validamos si el email es correcto
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "El email no es válido.";
                    $view = 'view/log/registro.php';
                    include_once 'view/main.php';
                    return;
                }

                //Comprobamos que la contraseña sea mayor de 6 digitos
                if (strlen($contraseña) < 6) {
                    $error = "La contraseña debe tener almenos 6 caracteres.";
                    $view = 'view/log/registro.php';
                    include_once 'view/main.php';
                    return;
                }

                //Registramos usuario
                $exito = UsuarioDAO::registrarusuarios($nombre, $email, $contraseña, $direccion, $telefono);

                if ($exito) {
                    //Obtenemos el usuario recien creado para iniciar sesion automaticamente
                    $usuario = UsuarioDAO::validarUsuario($email, $contraseña);
                    $_SESSION['usuario'] = $usuario;
                    header('Location: index.php?controller=Home&action=verHome');
                    exit;
                } else {
                    //Error al registrar (email ya existe)
                    $error = "El email ya está registrado.";
                    $view = 'view/log/registro.php';
                    include_once 'view/main.php';
                }           

            } else {
                //Si no se han enviado todos los campos obligatorios
                $error = "Por favor, completa todos los campos obligatorios.";
                $view = 'view/log/registro.php';
                include_once 'view/main.php';
            }
        }
    }