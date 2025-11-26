<?php
// Redirigir al usuario a la página principal
include_once 'controller/CategoriaController.php';
include_once 'view/home.php';

// Verificar si se pasa un controlador en la URL
if (isset($_GET['controller'])) {
    $nombre_controller = $_GET['controller'] . 'Controller';
    if (class_exists($nombre_controller)) {
        $controller = new $nombre_controller();
        $action = isset($_GET['action']) ? $_GET['action'] : 'index';
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            echo "<h1>Acción no encontrada</h1>";
        }
    } else {
        echo "<h1>Controlador no encontrado</h1>";
    }
} else {
    // Acción por defecto si no se pasa un controlador
    $categoriaController = new CategoriaController();
    $categoriaController->index();
}
