<!-- CSS del carrito -->
<link rel="stylesheet" href="assets/css/carrito.css">

<!-- Contenedor principal -->
<div class="carrito-page">
    <section class="confirmacion-container">
        <div class="confirmacion-icono">
            <i class="bi bi-check-lg"></i>
        </div>
        <h1>¡Pedido Realizado!</h1>
        <p class="confirmacion-mensaje">Tu pedido ha sido procesado correctamente.</p>
        
        <?php if (isset($pedido) && $pedido): ?>
            <div class="confirmacion-detalles">
                <h2>Detalles del Pedido</h2>
                <p><strong>Número de pedido:</strong> #<?= $pedido->getId_pedido() ?></p>
                <p><strong>Fecha:</strong> <?= $pedido->getFecha() ?></p>
                <p><strong>Estado:</strong> <?= ucfirst($pedido->getEstado()) ?></p>
                <p><strong>Total:</strong> <?= number_format($pedido->getImporte_total(), 2) ?> €</p>
            </div>
        <?php endif; ?>
        
        <div class="confirmacion-acciones">
            <a href="?controller=Home&action=verHome" class="btn btn-cupra-solid px-4 py-3">VOLVER AL INICIO</a>
            <a href="?controller=Producto&action=verCarta" class="btn btn-cupra-copper px-4 py-3">VER CARTA</a>
        </div>
    </section>
</div>
