<?php
include_once 'model/Usuario.php';

class AdminController{

    public function verPanel(){
        // Verificamos que el usuario esta logueado y es admin
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() !== 'admin') {
            header('Location: index.php?controller=Log&action=verLogin');
            exit;
        }

        // No necesitamos cargar datos aqui, se cargan con JavaScript desde la API
        $view = 'view/admin/dashboard.php';
        include_once 'view/main.php';
    }
}