<link rel="stylesheet" href="assets/css/carrito.css">

<section class="confirmacion-container">
    <div class="confirmacion-icono">✓</div>
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
        <a href="?controller=Home&action=verHome" class="btn-inicio">Volver al Inicio</a>
        <a href="?controller=Producto&action=verCarta" class="btn-carta">Ver Carta</a>
    </div>
</section>
