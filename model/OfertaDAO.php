<?php
include_once __DIR__ . '/Oferta.php';
include_once __DIR__ . '/../database/database.php';


class OfertaDAO{

    public static function crear($oferta){
        $con = Database::connect();
        $stmt = $con->prepare("INSERT INTO `oferta` (nombre, descripcion, descuento_porcentaje, fecha_inicio, fecha_fin, activa) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssdssi', 
            $oferta->nombre, 
            $oferta->descripcion, 
            $oferta->descuento_porcentaje,
            $oferta->fecha_inicio,
            $oferta->fecha_fin,
            $oferta->activa
        );
        $stmt->execute();
        $id = $con->insert_id;
        $con->close();

        return $id;
    }

    public static function actualizar($oferta){
        $con = Database::connect();
        $stmt = $con->prepare("UPDATE `oferta` SET nombre = ?, descripcion = ?, descuento_porcentaje = ?, fecha_inicio = ?, fecha_fin = ?, activa = ? WHERE id_oferta = ?");
        $stmt->bind_param('ssdssii', 
            $oferta->nombre, 
            $oferta->descripcion, 
            $oferta->descuento_porcentaje,
            $oferta->fecha_inicio,
            $oferta->fecha_fin,
            $oferta->activa,
            $oferta->id_oferta
        );
        $result = $stmt->execute();
        $con->close();

        return $result;
    }

    public static function eliminar($id_oferta){
        $con = Database::connect();
        
        // Primero eliminar las relaciones en oferta_producto
        $stmt = $con->prepare("DELETE FROM `oferta_producto` WHERE id_oferta = ?");
        $stmt->bind_param('i', $id_oferta);
        $stmt->execute();
        
        // Luego eliminar la oferta
        $stmt = $con->prepare("DELETE FROM `oferta` WHERE id_oferta = ?");
        $stmt->bind_param('i', $id_oferta);
        $result = $stmt->execute();
        
        $con->close();
        return $result;
    }

    public static function getOfertaById($id_oferta){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `oferta` WHERE id_oferta = ?");
        $stmt->bind_param('i', $id_oferta);
        $stmt->execute();
        $results = $stmt->get_result();

        $oferta = $results->fetch_object('Oferta');
        $con->close();

        return $oferta;
    }

    public static function getOfertas(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `oferta`");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaOfertas = [];
        while ($oferta = $results->fetch_object('Oferta')) {
            $listaOfertas[] = $oferta;
        }

        $con->close();
        return $listaOfertas;
    }

    public static function getOfertasActivas(){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `oferta` WHERE activa = 1 AND fecha_inicio <= NOW() AND fecha_fin >= NOW()");
        $stmt->execute();
        $results = $stmt->get_result();

        $listaOfertas = [];
        while ($oferta = $results->fetch_object('Oferta')) {
            $listaOfertas[] = $oferta;
        }

        $con->close();
        return $listaOfertas;
    }

    public static function getProductosOferta($id_oferta){
        $con = Database::connect();
        $stmt = $con->prepare("SELECT * FROM `oferta_producto` WHERE id_oferta = ?");
        $stmt->bind_param('i', $id_oferta);
        $stmt->execute();
        $results = $stmt->get_result();

        $listaProductos = [];
        while ($row = $results->fetch_assoc()) {
            $listaProductos[] = $row;
        }

        $con->close();
        return $listaProductos;
    }

    public static function agregarProducto($id_oferta, $id_producto, $precio_especial = null, $cantidad = null){
        $con = Database::connect();
        $stmt = $con->prepare("INSERT INTO `oferta_producto` (id_oferta, id_producto, precio_especial, cantidad) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('iidi', $id_oferta, $id_producto, $precio_especial, $cantidad);
        $result = $stmt->execute();
        $con->close();

        return $result;
    }

    public static function eliminarProducto($id_oferta, $id_producto){
        $con = Database::connect();
        $stmt = $con->prepare("DELETE FROM `oferta_producto` WHERE id_oferta = ? AND id_producto = ?");
        $stmt->bind_param('ii', $id_oferta, $id_producto);
        $result = $stmt->execute();
        $con->close();

        return $result;
    }

    public static function getOfertaPorProducto($id_producto){
        $con = Database::connect();
        $stmt = $con->prepare("
            SELECT o.*, op.precio_especial, op.cantidad 
            FROM `oferta` o
            INNER JOIN `oferta_producto` op ON o.id_oferta = op.id_oferta
            WHERE op.id_producto = ? 
            AND o.activa = 1 
            AND o.fecha_inicio <= NOW() 
            AND o.fecha_fin >= NOW()
            LIMIT 1
        ");
        $stmt->bind_param('i', $id_producto);
        $stmt->execute();
        $results = $stmt->get_result();

        $oferta = $results->fetch_assoc();
        $con->close();

        return $oferta;
    }

}