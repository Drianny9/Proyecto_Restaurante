<!-- CSS especifico para la carta de productos -->
<link rel="stylesheet" href="assets/css/carta.css">

<!-- Seccion principal de la carta -->
<section class="carta-container">
    
    <!-- Titulo y descripcion de la pagina -->
    <div class="carta-header">
        <h1>ENCUENTRA TU SABOR CUPRA</h1>
        <p>Descubre platos creados con pasion y precision.</p>
    </div>

    <!-- Contenedor principal: filtros a la izquierda, productos a la derecha -->
    <div class="carta-content">
        
        <!-- Panel de filtros lateral -->
        <aside class="filtros-panel">
            <h2>FILTROS</h2>
            <p class="filtros-subtitulo">TIPO DE PRODUCTO</p>
            
            <!-- Lista de categorias para filtrar -->
            <div class="filtros-categorias">
                <h3 class="categoria-titulo">CATEGORIAS</h3>
                
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): //Los : equivalen a {} , pero hay que poner endforeach al final en lugar de }?>
                        <!-- Cada categoria es un checkbox para filtrar -->
                        <label class="filtro-item">
                            <input type="checkbox" class="filtro-checkbox" data-categoria="<?= $categoria->getIdCategoria() ?>">
                            <!-- Aqui puedes añadir un icono de categoria si quieres -->
                            <span class="filtro-nombre"><?= $categoria->getNombre() ?></span>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </aside>

        <!-- Mostramos tarjetas de productos -->
        <div class="productos-grid">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    
                    <!-- Tarjeta de producto individual -->
                    <article class="producto-card" data-categoria="<?= $producto->getId_categoria() ?>">
                        
                        <!-- Imagen del producto con boton de favorito -->
                        <div class="producto-imagen-container">
                            <img src="assets/images/productos/<?= $producto->getImagen() ?>" alt="<?= $producto->getNombre() ?>" class="producto-imagen">
                            <!-- Boton de favorito (corazon) -->
                            <button class="btn-favorito">
                                <span class="icono-corazon">♡</span>
                            </button>
                            <!-- Etiqueta de categoria (ej: NUEVO, OFERTA) -->
                            <span class="producto-etiqueta">NUEVO</span>
                        </div>

                        <!-- Informacion del producto -->
                        <div class="producto-info">
                            <h3 class="producto-nombre"><?= $producto->getNombre() ?></h3>
                            <p class="producto-descripcion"><?= $producto->getDescripcion() ?></p>
                            
                            <!-- Precio -->
                            <p class="producto-precio">
                                <span class="precio-label">Precio recomendado:</span>
                                <span class="precio-valor"><?= number_format($producto->getPrecio_base(), 2) ?> €</span>
                            </p>

                            <!-- Calorias de productos -->
                            <p class="producto-calorias">
                                <span class="calorias-icono">ⓘ</span>
                                <span>Calorias: XXX Kcal</span>
                            </p>

                            <!-- Checkbox para añadir al carrito -->
                            <label class="añadir-carrito">
                                <input type="checkbox" class="carrito-checkbox">
                                <span>Añadir al carrito</span>
                            </label>

                            <!-- Boton ver detalles -->
                            <a href="?controller=Producto&action=verDetalle&id=<?= $producto->getId_producto() ?>" 
                               class="btn-ver-detalles">
                                VER DETALLES
                            </a>
                        </div>
                    </article>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-productos">No hay productos disponibles.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- Script para filtrar productos por categoria -->
<script src="assets/js/carta/filtros.js"></script>