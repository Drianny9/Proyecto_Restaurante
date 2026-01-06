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
        
        $id_pedido = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        if ($id_pedido > 0) {
            $pedido = PedidoDAO::getPedidoById($id_pedido);
            $lineas = LineaPedidoDAO::getLineasByPedido($id_pedido);
            
            // Obtener datos de productos para cada línea
            $productosLineas = [];
            foreach ($lineas as $linea) {
                $producto = ProductoDAO::getProductoById($linea->getId_producto());
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
