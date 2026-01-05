<?php
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/../model/OfertaDAO.php';

// Solo permitir GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    respuestaJSON('Fallido', null, 'Método no permitido', 405);
}

// Obtener oferta activa para un producto específico
if (isset($_GET['producto'])) {
    $oferta = OfertaDAO::getOfertaPorProducto($_GET['producto']);
    respuestaJSON('Exito', $oferta);
}

// Si no se especifica producto, error
respuestaJSON('Fallido', null, 'Parámetro "producto" requerido', 400);
