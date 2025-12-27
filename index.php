<?php
//Primero incluimos la clase Usuario para que no se inicie sesion antes
include_once 'model/Usuario.php';

session_start();

include_once 'controller/HomeController.php';
include_once 'controller/LogController.php';
include_once 'controller/RegistroController.php';
include_once 'controller/ProductoController.php';
include_once 'controller/AdminController.php';

// Valores por defecto
$defaultController = 'Home';
$defaultAction = 'verHome';

// Leer controlador de forma segura
//$controller = $_GET['controller'] ?? null; Asigna el valor de la izquierda si encuentra controller y si no null, es lo mismo que hacer el if
if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
} else {
    $controller = null;
}


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
$action = $_GET['action'] ?? $defaultAction;

// Ejecutar accion si existe
if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    echo "<h1>Acción no encontrada</h1>";
}
