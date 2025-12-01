<?php
include_once 'controller/HomeController.php';

// Valores por defecto
$defaultController = 'Home';
$defaultAction = 'verHome';

// Leer controlador de forma segura
$controller = $_GET['controller'] ?? null;

// Decidir que controlador instanciar
if ($controller) {
    $nombre_controller = $controller . 'Controller';
    if (class_exists($nombre_controller)) {
        $controller = new $nombre_controller();
    } else {
        echo "<h1>Controlador no encontrado</h1>";
        exit;
    }
} else {
    // Sin parametro => HomeController por defecto
    $controller = new HomeController();
}

// Forzar accion inicial a 'verHome'
$action = $defaultAction;

// Ejecutar accion si existe
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "<h1>Acción no encontrada</h1>";
}
