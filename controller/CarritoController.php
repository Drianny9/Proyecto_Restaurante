<?php
include_once 'model/ProductoDAO.php';
include_once 'model/PedidoDAO.php';
include_once 'model/LineaPedidoDAO.php';

class CarritoController{
     
    //Mostrar carrito
    public function verCarrito(){
        $view = 'view/carrito/ver.php';
        include_once 'view/main.php';
    }
    
    //Mostrar página de checkout/pago
    public function checkout(){
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=Log&action=verLogin');
            exit;
        }
        
        $view = 'view/carrito/checkout.php';
        include_once 'view/main.php';
    }
    
    //Mostrar página de confirmación
    public function confirmacion(){
        // Verificar que el usuario esté logueado
        if (!isset($_SESSION['usuario'])) {
            header('Location: index.php?controller=Log&action=verLogin');
            exit;
        }
        
        //Convertimos el valor a entero para evitar valores no validos o errores.
        $id_pedido = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id_pedido > 0) {
            $pedido = PedidoDAO::getPedidoById($id_pedido);
            $lineas = LineaPedidoDAO::getLineasByPedido($id_pedido);
            
            //Array para almacenar cada linea de pedido junto a su producto correspondiente
            $productosLineas = [];
            //Obtenemos todas las lineas de pedido
            foreach ($lineas as $linea) {
                $producto = ProductoDAO::getProductoById($linea->getId_producto());
                //Guardamos linea y producto juntos para acceder a los datos facilmente
                $productosLineas[] = [
                    'linea' => $linea,
                    'producto' => $producto
                ];
            }
        }
        
        $view = 'view/carrito/confirmacion.php';
        include_once 'view/main.php';
    }
}
