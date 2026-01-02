<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<!-- Nav CSS -->
<link rel="stylesheet" href="assets/css/nav.css">

<!-- Navbar (transparente para home, fija para otras páginas) -->
<nav class="navbar navbar-expand-lg navbar-dark <?php echo (isset($_GET['controller']) && $_GET['controller'] != 'Home') ? 'fixed-top navbar-solid' : ''; ?>">
    <div class="container-fluid px-4 px-lg-5">
        
        <!-- Logo CUPRA EATS -->
        <a class="navbar-brand" href="?controller=Home&action=verHome">
            <img src="assets/images/logos/Logo_cupra_eats.svg" alt="CUPRA EATS" class="logo-img">
        </a>
        
        <!-- Menú derecho (siempre visible en desktop) -->
        <div class="navbar-nav-right d-flex align-items-center">
            
            <!-- Botones principales -->
            <div class="nav-buttons d-none d-lg-flex align-items-center">
                <a href="#encuentranos" class="btn btn-nav-outline me-2">ENCUÉNTRANOS</a>
                <a href="?controller=Producto&action=verCarta" class="btn btn-nav-filled me-3">CONFIGURADOR</a>
                <a href="#cookies" class="nav-link-text me-4">COOKIES</a>
            </div>
            
            <!-- Iconos -->
            <div class="nav-icons d-flex align-items-center">
                <!-- Icono Idioma/Globo -->
                <a href="#idioma" class="nav-icon-link">
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
                        </svg>
                    </div>
                </a>
                
                <!-- Icono Usuario -->
                <a href="?controller=Usuario&action=login" class="nav-icon-link">
                    <div class="icon-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </div>
                </a>
                
                <!-- Menú Hamburguesa -->
                <button class="nav-hamburger" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Offcanvas Menu (móvil y hamburguesa) -->
<div class="offcanvas offcanvas-end bg-dark" tabindex="-1" id="menuOffcanvas">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title text-white">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white py-3" href="?controller=Home&action=verHome">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white py-3" href="?controller=Producto&action=verCarta">Carta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white py-3" href="#nosotros">Nosotros</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white py-3" href="?controller=Carrito&action=verCarrito">
                    Carrito <span class="badge bg-danger" id="contador-carrito-menu">0</span>
                </a>
            </li>
        </ul>
    </div>
</div>
                        🛒 Carrito
                        <span id="contador-carrito" class="contador-badge">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-link nav-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
                        <div class="hamburger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Offcanvas Menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="menuOffcanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="#productos">Productos</a></li>
            <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
        </ul>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>