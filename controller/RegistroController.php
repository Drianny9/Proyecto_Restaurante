<?php
include_once 'model/UsuarioDAO.php';
include_once 'model/LogDAO.php';

    class RegistroController{
        //Funcion para ver la pagina de registro
        public function verRegistro(){
            include_once 'view/log/registro.php';
        }

        //funcion para procesar los registros
        public function procesarRegistro(){
            //Comprobamos que existe nombre, email y contraseña y le asignamos lo que se pone en el formulario
            if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
                $nombre = trim($_POST['nombre']);
                $email = trim($_POST['email']);
                $password = $_POST['password'];
                $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : null;
                $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : null;

                //Verificamos que ninguna casilla este vacia
                if (empty($nombre) || empty($email) ||empty($password)) {
                    $error = "Por favor, complea todos los campos obligatorios.";
                    include_once 'view/log/registro.php';
                    return;
                }

                //Verificamos que el email contenga @
                if (strpos($email, '@') === false) { //strpos busca posición de subcadena en una cadena strpos(cadena, subcadena)
                    $error = "El email debe contener el símbolo @.";
                    include_once 'view/log/registro.php';
                    return;
                }

                //Con filter_var validamos si el email es correcto
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = "El email no es válido.";
                    include_once 'view/log/registro.php';
                    return;
                }

                //Comprobamos que la contraseña sea mayor de 6 digitos
                if (strlen($password) < 6) {
                    $error = "La contraseña debe tener almenos 6 caracteres.";
                    include_once 'view/log/registro.php';
                    return;
                }

                //Registramos usuario
                $exito = UsuarioDAO::registrarusuarios($nombre, $email, $password, $direccion, $telefono);

                if ($exito) {
                    //Obtener el usuario recien creado
                    $usuario = UsuarioDAO::validarUsuario($email, $password);
                    
                    //Registrar log de nuevo registro
                    $accion = "REGISTRO_NUEVO: Usuario {$email} creó una cuenta";
                    LogDAO::crearLog($accion, $usuario ? $usuario->getId_usuario() : null);
                    
                    //Iniciar sesion automaticamente
                    $_SESSION['usuario'] = $usuario;
                    header('Location: index.php?controller=Home&action=verHome');
                    exit;
                } else {
                    //Error al registrar (email ya existe)
                    $error = "El email ya está registrado.";
                    include_once 'view/log/registro.php';
                }           

            } else {
                //Si no se han enviado todos los campos obligatorios
                $error = "Por favor, completa todos los campos obligatorios.";
                include_once 'view/log/registro.php';
            }
        }
    }