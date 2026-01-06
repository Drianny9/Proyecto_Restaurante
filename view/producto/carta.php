<!-- CSS especifico para la carta de productos -->
<link rel="stylesheet" href="assets/css/carta.css">
<link rel="stylesheet" href="assets/css/hero.css">

<!-- Seccion principal de la carta -->
<section class="carta-container">
    
    <!-- Titulo y descripcion de la pagina -->
    <div class="carta-header">
        <h1>ENCUENTRA TU SABOR CUPRA</h1>
        <p>Descubre platos creados con pasión y precisión.</p>
    </div>

    <!-- Contenedor principal: filtros a la izquierda, productos a la derecha -->
    <div class="carta-content">
        
        <!-- Panel de filtros lateral -->
        <aside class="filtros-panel">
            <h2>FILTROS</h2>
            <p class="filtros-subtitulo">TIPO DE PRODUCTO</p>
            
            <div class="filtros-separador"></div>
            
            <!-- Header de categorias con flecha -->
            <div class="categoria-header" id="categoriaToggle">
                <h3 class="categoria-titulo">CATEGORÍAS</h3>
                <span class="categoria-arrow">
                    <i class="bi bi-chevron-up"></i>
                </span>
            </div>
            
            <!-- Lista de categorias para filtrar -->
            <div class="filtros-categorias" id="categoriasLista">
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <!-- Cada categoria es un checkbox para filtrar -->
                        <label class="filtro-item">
                            <input type="checkbox" class="filtro-checkbox" data-categoria="<?= $categoria->getIdCategoria() ?>">
                            <div class="filtro-icono">
                                <?php 
                                    // Mapeo de categorías a imágenes para poder verlo en el server
                                    $imagenCategoria = '';
                                    switch($categoria->getIdCategoria()) {
                                        case 1: $imagenCategoria = 'Entrante.webp'; break;
                                        case 2: $imagenCategoria = 'Principal.webp'; break;
                                        case 3: $imagenCategoria = 'Bebida.webp'; break;
                                        case 4: $imagenCategoria = 'Postre.webp'; break;
                                    }
                                ?>
                                <img src="assets/images/filtros/<?= $imagenCategoria ?>" alt="<?= $categoria->getNombre() ?>">
                            </div>
                            <span class="filtro-nombre"><?= strtoupper($categoria->getNombre()) ?></span>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </aside>

        <!-- Grid de tarjetas de productos -->
        <div class="productos-grid">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    
                    <!-- Tarjeta de producto individual -->
                    <article class="producto-card" 
                             data-categoria="<?= $producto->getId_categoria() ?>"
                             data-producto-id="<?= $producto->getId_producto() ?>"
                             data-precio-base="<?= $producto->getPrecio_base() ?>">
                        
                        <!-- Imagen del producto con boton de favorito -->
                        <div class="producto-imagen-container">
                            <img src="assets/images/carta/<?= $producto->getImagen() ?>" 
                                 alt="<?= $producto->getNombre() ?>" 
                                 class="producto-imagen">
                            
                            <!-- Boton de favorito (corazon) -->
                            <button class="btn-favorito" aria-label="Añadir a favoritos">
                                <i class="bi bi-heart"></i>
                            </button>
                            
                            <!-- Etiqueta de categoria -->
                            <?php 
                                $nombreCategoria = '';
                                foreach ($categorias as $cat) {
                                    if ($cat->getIdCategoria() == $producto->getId_categoria()) {
                                        $nombreCategoria = $cat->getNombre();
                                        break;
                                    }
                                }
                            ?>
                            <span class="producto-etiqueta"><?= strtoupper($nombreCategoria) ?></span>
                        </div>

                        <!-- Informacion del producto -->
                        <div class="producto-info">
                            <h3 class="producto-nombre"><?= strtoupper($producto->getNombre()) ?></h3>
                            <p class="producto-descripcion"><?= $producto->getDescripcion() ?></p>
                            
                            <div class="producto-separador"></div>
                            
                            <!-- Precio -->
                            <p class="producto-precio" data-precio-elemento>
                                <span class="precio-label">Precio recomendado</span>
                                <span class="precio-valor"><?= number_format($producto->getPrecio_base(), 0) ?> €</span>
                            </p>

                            <div class="producto-separador"></div>

                            <!-- Calorias -->
                            <p class="producto-calorias">
                                <span class="calorias-icono">i</span>
                                <span>Calorías: <?= rand(200, 500) ?> Kcal</span>
                            </p>

                            <div class="producto-separador"></div>

                            <!-- Boton añadir al carrito -->
                            <button class="btn btn-cupra-solid w-100" 
                                    onclick="añadirAlCarrito(<?= $producto->getId_producto() ?>, '<?= addslashes($producto->getNombre()) ?>', <?= $producto->getPrecio_base() ?>, '<?= $producto->getImagen() ?>')">
                                AÑADIR AL CARRITO
                            </button>
                        </div>
                    </article>

                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-productos">No hay productos disponibles.</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- ============ TEMPLATES PARA OFERTAS ============ -->

<!-- Template: Badge de oferta (precio especial) -->
<template id="template-badge-oferta">
    <span class="badge bg-danger position-absolute top-0 start-0 m-2" style="z-index: 10;">OFERTA</span>
</template>

<!-- Template: Badge de descuento porcentual -->
<template id="template-badge-descuento">
    <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2" style="z-index: 10;"></span>
</template>

<!-- Template: Badge de cantidad (2x1, etc) -->
<template id="template-badge-cantidad">
    <span class="badge bg-info text-dark position-absolute top-0 start-0 m-2" style="z-index: 10;"></span>
</template>

<!-- Script para filtrar productos por categoria -->
<script src="assets/js/carta/filtros.js"></script>
<!-- Script del carrito (añadir productos) -->
<script src="assets/js/carrito.js"></script>
<!-- Script para mostrar ofertas en la carta -->
<script src="assets/js/carta/ofertas.js"></script>