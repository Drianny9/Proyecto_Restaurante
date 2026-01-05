<!-- CSS del carrito/checkout -->
<link rel="stylesheet" href="assets/css/carrito.css">
<link rel="stylesheet" href="assets/css/hero.css">

<!-- Contenedor principal del checkout -->
<div class="carrito-page">

    <!-- Contenido principal del checkout -->
    <section class="checkout-content py-5">
        <div class="container">
            <div class="row g-5">
                
                <!-- Columna izquierda: Resumen del pedido -->
                <div class="col-lg-6">
                    
                    <h2 class="checkout-titulo mb-4">RESUMEN DEL PEDIDO</h2>
                    
                    <!-- Lista de productos del carrito -->
                    <div id="checkout-productos" class="mb-4">
                        <p class="text-white-50">Cargando productos...</p>
                    </div>
                    
                    <hr class="checkout-divider">
                    
                    <!-- Totales -->
                    <div class="checkout-totales mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-white-50">Subtotal</span>
                            <span class="text-white" id="checkout-subtotal">0,00 €</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-white-50">IVA (10%)</span>
                            <span class="text-white" id="checkout-iva">0,00 €</span>
                        </div>
                        
                        <hr class="checkout-divider">
                        
                        <div class="d-flex justify-content-between mt-3">
                            <span class="text-white fw-bold fs-5">TOTAL</span>
                            <span class="text-white fw-bold fs-5" id="checkout-total">0,00 €</span>
                        </div>
                    </div>
                    
                </div>
                
                <!-- Columna derecha: Formulario de pago -->
                <div class="col-lg-6">
                    <div class="checkout-pago p-4 rounded-3" style="background: rgb(33, 35, 41); border: 1px solid rgba(255, 255, 255, 0.1);">
                        
                        <h2 class="checkout-titulo mb-4">PAGO</h2>
                        
                        <!-- Formulario de datos -->
                        <form id="form-checkout">
                            <div class="mb-3">
                                <input type="text" class="form-control carrito-input" id="nombre-completo" placeholder="Nombre completo" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control carrito-input" id="correo" placeholder="Correo electrónico" required>
                            </div>
                            <div class="mb-4">
                                <input type="text" class="form-control carrito-input" id="direccion" placeholder="Dirección" required>
                            </div>
                            
                            <!-- Métodos de pago -->
                            <h4 class="text-white mb-3" style="font-size: 14px; letter-spacing: 1px;">MÉTODOS DE PAGO</h4>
                            
                            <div class="metodos-pago d-flex gap-4 mb-4">
                                <label class="metodo-pago-item">
                                    <input type="radio" name="metodo-pago" value="visa" checked>
                                    <img src="assets/images/logos/Visa.svg" alt="Visa" class="metodo-pago-logo">
                                </label>
                                <label class="metodo-pago-item">
                                    <input type="radio" name="metodo-pago" value="apple">
                                    <img src="assets/images/logos/Apple Pay.svg" alt="Apple Pay" class="metodo-pago-logo">
                                </label>
                                <label class="metodo-pago-item">
                                    <input type="radio" name="metodo-pago" value="paypal">
                                    <img src="assets/images/logos/PayPal.svg" alt="PayPal" class="metodo-pago-logo">
                                </label>
                                <label class="metodo-pago-item">
                                    <input type="radio" name="metodo-pago" value="bizum">
                                    <img src="assets/images/logos/Bizum.svg" alt="Bizum" class="metodo-pago-logo">
                                </label>
                            </div>
                            
                            <!-- Botón finalizar -->
                            <button type="submit" class="btn btn-cupra-copper w-100 py-3">
                                FINALIZAR PEDIDO
                            </button>
                        </form>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>

</div>

<!-- Script del carrito (funciones compartidas) -->
<script src="assets/js/carrito.js"></script>
<!-- Script del checkout -->
<script src="assets/js/checkout.js"></script>
