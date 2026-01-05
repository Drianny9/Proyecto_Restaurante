<!-- CSS del carrito -->
<link rel="stylesheet" href="assets/css/carrito.css">

<!-- Contenedor principal del carrito -->
<div class="carrito-page">

    <!-- Header del carrito -->
    <section class="carrito-header">
    <div class="container">
        <!-- Seguir comprando -->
        <a href="?controller=Producto&action=verCarta" class="text-white-50 text-decoration-none d-inline-flex align-items-center mb-3" style="font-size: 14px;">
            <i class="bi bi-arrow-left me-2"></i> SEGUIR COMPRANDO
        </a>
        
        <!-- Título principal -->
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="font-exo text-white mb-0" style="font-size: 36px; font-weight: 300; letter-spacing: 2px;">
                REALIZA TU PEDIDO
            </h1>
            <a href="?controller=Carrito&action=checkout" class="btn btn-cupra-solid px-4 py-2">
                SIGUIENTE
            </a>
        </div>
    </div>
</section>

<!-- Contenido principal del carrito -->
<section class="carrito-content py-5">
    <div class="container">
        <div class="row g-4">
            
            <!-- Columna izquierda: Lista de productos -->
            <div class="col-lg-8">
                
                <!-- Lista de productos (renderizada por JS) -->
                <div id="lista-productos-carrito">
                    <p class="text-white-50">Cargando carrito...</p>
                </div>
                
            </div>
            
            <!-- Columna derecha: Resumen del pedido -->
            <div class="col-lg-4">
                <div class="resumen-pedido p-4 rounded-3" style="background: rgb(33, 35, 41); border: 1px solid rgba(255, 255, 255, 0.1);">
                    
                    <h3 class="text-white font-exo mb-4" style="font-size: 18px; letter-spacing: 1px;">
                        RESUMEN DEL PEDIDO
                    </h3>
                    
                    <!-- Código de descuento -->
                    <div class="mb-4">
                        <label class="text-white-50 small mb-2 d-block">Código de descuento</label>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control carrito-input" id="codigo-descuento" placeholder="Introduce tu código">
                            <button class="btn btn-cupra-outline px-3" style="white-space: nowrap;">APLICAR</button>
                        </div>
                    </div>
                    
                    <hr style="border-color: rgba(255, 255, 255, 0.1);">
                    
                    <!-- Totales -->
                    <div class="totales mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Subtotal</span>
                            <span class="text-white" id="subtotal-carrito">0,00 €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" id="descuento-row" style="display: none;">
                            <span class="text-success">Descuento (Ofertas)</span>
                            <span class="text-success" id="descuento-carrito">0,00 €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50">IVA (10%)</span>
                            <span class="text-white" id="iva-carrito">0,00 €</span>
                        </div>
                        
                        <hr style="border-color: rgba(255, 255, 255, 0.1);">
                        
                        <div class="d-flex justify-content-between mt-3 mb-4">
                            <span class="text-white fw-bold" style="font-size: 18px;">TOTAL</span>
                            <span class="text-white fw-bold" id="total-carrito" style="font-size: 18px;">0,00 €</span>
                        </div>
                    </div>
                    
                    <!-- Botón tramitar -->
                    <button class="btn btn-cupra-copper w-100 py-3" onclick="tramitarPedido()">
                        TRAMITAR PEDIDO
                    </button>
                    
                </div>
            </div>
            
        </div>
    </div>
</section>

</div>

<!-- ============ TEMPLATES ============ -->

<!-- Template: Carrito vacío -->
<template id="template-carrito-vacio">
    <div class="carrito-vacio">
        <div class="carrito-vacio-icono">
            <i class="bi bi-cart-x"></i>
        </div>
        <h2>Tu carrito está vacío</h2>
        <p>Explora nuestra carta y añade productos deliciosos</p>
        <a href="?controller=Producto&action=verCarta" class="btn btn-cupra-solid px-5 py-3">
            VER CARTA
        </a>
    </div>
</template>

<!-- Template: Producto en carrito -->
<template id="template-producto-carrito">
    <div class="producto-card" data-id="">
        <div class="row align-items-center g-3">
            <!-- Imagen -->
            <div class="col-auto">
                <img src="" alt="" class="producto-imagen">
            </div>
            
            <!-- Info del producto -->
            <div class="col">
                <h4 class="producto-nombre"></h4>
                <p class="producto-precio mb-0"></p>
            </div>
            
            <!-- Control de cantidad -->
            <div class="col-auto">
                <div class="control-cantidad">
                    <button class="btn-cantidad btn-restar">
                        <i class="bi bi-dash"></i>
                    </button>
                    <span class="cantidad-valor"></span>
                    <button class="btn-cantidad btn-sumar">
                        <i class="bi bi-plus"></i>
                    </button>
                </div>
            </div>
            
            <!-- Subtotal -->
            <div class="col-auto text-end" style="min-width: 100px;">
                <span class="producto-subtotal"></span>
            </div>
            
            <!-- Eliminar -->
            <div class="col-auto">
                <button class="btn-eliminar-producto" title="Eliminar">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<!-- Script del carrito -->
<script src="assets/js/carrito.js"></script>