<!-- Navbar Transparente -->
<nav class="navbar navbar-expand-lg navbar-dark position-absolute w-100 p-4" style="z-index: 10;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="?controller=Home&action=verHome">
            <img src="assets/images/logos/Logo_cupra_eats.svg" alt="CUPRA EATS" width="180" height="auto" class="d-inline-block">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-4">
                <li class="nav-item"><a class="nav-link" href="?controller=Home&action=verHome">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=Producto&action=verCarta">CARTA</a></li>
                <li class="nav-item"><a class="nav-link" href="#nosotros">NOSOTROS</a></li>
                
                <li class="d-none d-lg-block text-white opacity-50">|</li>

                <li class="nav-item">
                    <a class="nav-link position-relative" href="?controller=Carrito&action=verCarrito">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="contador-carrito" style="font-size: 0.6rem;">0</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=Log&action=verLogin"><i class="bi bi-person fs-5"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas"><i class="bi bi-list fs-4"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Offcanvas Menu -->
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
