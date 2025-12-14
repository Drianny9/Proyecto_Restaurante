<head>
    <link rel="stylesheet" href="assets/css/producto.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Nuestra Carta</h1>
        
        <div class="row">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="assets/images/productos/<?= $producto->getImagen() ?>" 
                                 class="card-img-top" 
                                 alt="<?= $producto->getNombre() ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $producto->getNombre() ?></h5>
                                <p class="card-text"><?= $producto->getDescripcion() ?></p>
                                <p class="precio"><?= number_format($producto->getPrecioBase(), 2) ?>€</p>
                                <a href="?controller=Producto&action=verDetalle&id=<?= $producto->getIdProducto() ?>" 
                                   class="btn btn-primary">Ver detalle</a>
                                <button class="btn btn-success">Añadir al carrito</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No hay productos disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</body>