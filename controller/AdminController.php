<?php
include_once 'model/UsuarioDAO.php';
include_once 'model/ProductoDAO.php';
include_once 'model/LineaPedidoDAO.php';

class AdminController{

    public function verPanel(){
        //Verificamos que el usuario esta logueado y es admin
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']->getRol() !== 'admin') {
            header('Location: index.php?controller=Log&action=verLogin');
            exit;
        }

        //Obtenemis datos para el panel
        $usuarios = UsuarioDAO::getUsuarios();
        $usuarios = ProductoDAO::getProductos();
        $usuarios = LineaPedidoDAO::getLineasPedido();

        $view = 'view/admin/dashboard';
        include_once 'view/main.php';
    }
}