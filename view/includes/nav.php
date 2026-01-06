<!-- Navbar Transparente -->
<nav class="navbar navbar-expand-lg navbar-dark position-absolute w-100 p-4" style="z-index: 10;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="?controller=Home&action=verHome">
            <img src="assets/images/logos/Logo_cupra_eats.svg" alt="CUPRA EATS" width="180" height="auto" class="d-inline-block">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center gap-4">
                <li class="nav-item"><a class="nav-link" href="?controller=Home&action=verHome">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=Producto&action=verCarta">CARTA</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=Nosotros&action=verNosotros">NOSOTROS</a></li>
                
                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-bold" href="?controller=Admin&action=verPanel">
                        <i class="bi bi-gear-fill"></i> ADMIN
                    </a>
                </li>
                <?php endif; ?>
                
                <li class="d-none d-lg-block text-white opacity-50">|</li>

                <li class="nav-item">
                    <a class="nav-link position-relative" href="?controller=Carrito&action=verCarrito">
                        <i class="bi bi-cart3 fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="contador-carrito" style="font-size: 0.6rem;">0</span>
                    </a>
                </li>
                
                <?php if (isset($_SESSION['usuario'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-fill fs-5"></i> <?php echo htmlspecialchars($_SESSION['usuario']->getNombre()); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="background-color: rgba(17, 17, 17, 0.95); border: 1px solid rgba(166, 109, 86, 0.2);">
                        <li><a class="dropdown-item text-white dropdown-item-no-hover" href="?controller=Log&action=cerrarSesion" style="background-color: transparent !important;">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=Log&action=verLogin"><i class="bi bi-person fs-5"></i></a>
                </li>
                <?php endif; ?>
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
                <a class="nav-link text-white py-3" href="?controller=Nosotros&action=verNosotros">Nosotros</a>
            </li>
            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']->getRol() === 'admin'): ?>
            <li class="nav-item">
                <a class="nav-link text-warning py-3" href="?controller=Admin&action=verPanel">
                    <i class="bi bi-gear-fill"></i> Panel Admin
                </a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link text-white py-3" href="?controller=Carrito&action=verCarrito">
                    Carrito <span class="badge bg-danger" id="contador-carrito-menu">0</span>
                </a>
            </li>
            
            <?php if (isset($_SESSION['usuario'])): ?>
            <li class="nav-item border-top border-secondary mt-3 pt-3">
                <div class="px-3 pb-2 text-white-50 small">
                    <i class="bi bi-person-fill"></i> <?php echo htmlspecialchars($_SESSION['usuario']->getNombre()); ?>
                </div>
                <a class="nav-link text-white py-3" href="?controller=Log&action=cerrarSesion">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </li>
            <?php else: ?>
            <li class="nav-item border-top border-secondary mt-3 pt-3">
                <a class="nav-link text-white py-3" href="?controller=Log&action=verLogin">
                    <i class="bi bi-person"></i> Iniciar sesión
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
