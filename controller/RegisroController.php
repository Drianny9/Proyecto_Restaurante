<?php
include_once 'model/UsuarioDAO.php';

    class RegistroController{
        //Funcion para ver la pagina de registro
        public function register(){
            $view = 'view/log/registro.php';
            include_once 'view/main.php';
        }

        //funcion para procesar los registros
        public function procesarRegistro(){
            
        }
    }