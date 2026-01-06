<!-- Usamos flatpickr para poder incluir un calendario a la hora de reservar -->
<head>
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
</head>

<!-- Hero Section -->
<section class="hero-section">

    <!-- Hero Content -->
    <div class="container h-100 d-flex align-items-center position-relative">
        <div class="hero-content text-white col-md-6 mt-5">
            <h5 class="text-uppercase ls-2 fw-light mb-0">CUPRA</h5>
            <h1 class="display-1 fw-light font-exo mb-3">BORN</h1>
            <p class="lead fw-light mb-4" style="max-width: 450px;">
                El sabor que redefine la grandeza. Una nueva era gastronómica inspirada en la energía y el diseño.
            </p>

            <div class="mb-4">
                <span class="d-block text-uppercase small text-white-50">POR</span>
                <span class="fs-2 fw-bold">25,00 €</span>
            </div>

            <div class="d-flex gap-3">
                <button class="btn btn-outline-light rounded-0 px-4 py-2">ENCUÉNTRANOS</button>
                <a href="?controller=Producto&action=verCarta" class="btn btn-light rounded-0 px-4 py-2 fw-bold">VER CARTA</a>
            </div>
        </div>
    </div>

    <!-- Carrusel Horizontal Inferior -->
    <div class="bottom-carousel-container">
        <div class="carousel-track d-flex gap-3 px-4 pb-4 overflow-auto">
            <div class="carousel-card text-center text-white">
                <div class="glass-box">
                    <img src="assets/images/carta/Tartar.webp" alt="Tartar" class="img-fluid" style="max-height: 80px;">
                    <small class="text-uppercase letter-spacing-1">TARTAR</small>
                </div>
            </div>
            <div class="carousel-card text-center text-white">
                <div class="glass-box">
                    <img src="assets/images/carta/Pulpo.webp" alt="Pulpo" class="img-fluid" style="max-height: 80px;">
                    <small class="text-uppercase letter-spacing-1">PULPO</small>
                </div>
            </div>
            <div class="carousel-card text-center text-white">
                <div class="glass-box">
                    <img src="assets/images/carta/Brownie.webp" alt="Brownie" class="img-fluid" style="max-height: 80px;">
                    <small class="text-uppercase letter-spacing-1">BROWNIE</small>
                </div>
            </div>
            <div class="carousel-card text-center text-white">
                <div class="glass-box">
                    <img src="assets/images/carta/Coctel.webp" alt="Cóctel" class="img-fluid" style="max-height: 80px;">
                    <small class="text-uppercase letter-spacing-1">CÓCTEL</small>
                </div>
            </div>
            <div class="carousel-card text-center text-white">
                <div class="glass-box">
                    <img src="assets/images/carta/Espresso.webp" alt="Espresso" class="img-fluid" style="max-height: 80px;">
                    <small class="text-uppercase letter-spacing-1">ESPRESSO</small>
                </div>
            </div>
        </div>
    </div>

</section>

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

<!-- Sección: La Experiencia -->
<section class="container-fluid py-5 bg-cupra-dark text-center position-relative">
    <div class="row justify-content-center py-5">
        <div class="col-lg-8">
            <h2 class="font-exo text-white mb-4" style="font-size: 40px; font-weight: 300; line-height: 1.2;">
                UNA NUEVA GENERACIÓN DE<br>
                EXPERIENCIAS GASTRONÓMICAS
            </h2>
            <p class="text-white-50 mx-auto" style="max-width: 600px; font-size: 16px; font-weight: 300; line-height: 1.6;">
                Sabores diseñados con precisión y energía, creados para desafiar lo convencional<br>
                y elevar la experiencia gastronómica a un nuevo nivel de diseño, emoción y sofisticación.
            </p>
        </div>
    </div>
</section>

<!-- Sección: Descubre Nuestro Mundo -->
<section class="position-relative w-100 overflow-hidden" style="min-height: 600px;">

    <img src="assets/images/home/Fondo_2.webp"
        alt="Ambiente Cupra"
        class="img-fluid w-100 h-100 object-fit-cover position-absolute top-0 start-0"
        style="z-index: 0;">

    <div class="overlay-gradient position-absolute w-100 h-100 top-0 start-0" style="z-index: 1;"></div>

    <div class="container position-relative h-100 d-flex flex-column justify-content-center align-items-center text-center" style="z-index: 2; min-height: 600px;">

        <h3 class="text-white font-exo fw-light mb-5 display-5">DESCUBRE NUESTRO MUNDO</h3>

        <div class="d-flex flex-column flex-md-row gap-4">
            <a href="?controller=Producto&action=verCarta" class="btn btn-cupra-solid px-5 py-3" style="border-radius: 4px;">
                VER CARTA COMPLETA
            </a>

            <a href="#reservar" class="btn btn-cupra-outline px-5 py-3 bg-black bg-opacity-25" style="border-radius: 4px;">
                RESERVAR MESA
            </a>
        </div>

    </div>
</section>

<!-- Sección: Mesas Disponibles -->
<section class="container-fluid py-5 bg-cupra-dark text-center position-relative" style="padding-top: 5rem !important; padding-bottom: 8rem !important;">

    <!-- Título -->
    <div class="mb-5">
        <h2 class="font-exo text-white mb-3" style="font-size: 48px; font-weight: 300; letter-spacing: 2px;">
            MESAS DISPONIBLES
        </h2>
        <p class="text-white-50 mx-auto" style="max-width: 800px; font-size: 16px; font-weight: 300;">
            Descubre la disponibilidad en CUPRA EATS y reserva tu experiencia gastronómica en el momento que prefieras, en<br>
            un entorno donde el diseño y el sabor se encuentran.
        </p>
    </div>

    <!-- Contenedor con imagen flotante -->
    <div class="container position-relative" style="max-width: 1200px; margin-top: 6rem;">

        <!-- Imagen del plato (flotante encima) -->
        <div class="position-absolute top-0 start-50 translate-middle" style="z-index: 10;">
            <img src="assets/images/home/Plato_tapado.webp" alt="Plato Cupra" style="width: 280px; height: auto;">
        </div>

        <!-- Recuadro de reserva -->
        <div class="reservation-box p-4 rounded-3" style="background: rgb(33, 35, 41); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); padding-top: 8.5rem !important; padding-bottom: 2.5rem !important;">

            <div class="row g-4 mb-4">
                <!-- Fecha -->
                <div class="col-md-3">
                    <label class="text-white text-start d-block mb-2 small">Fecha</label>
                    <input type="text" id="fecha-reserva" class="form-select reservation-select" placeholder="Selecciona un día" readonly="readonly">
                </div>

                
                <!-- Hora -->
                <div class="col-md-3">
                    <label class="text-white text-start d-block mb-2 small">Hora</label>
                    <input type="text" id="hora-reserva" class="form-select reservation-select" placeholder="Selecciona una hora" readonly="readonly">
                </div>

                <!-- Comensales -->
                <div class="col-md-3">
                    <label class="text-white text-start d-block mb-2 small">Comensales</label>
                    <select class="form-select reservation-select" placeholder = "Comensales">
                        <option value="1">1 persona</option>
                        <option value="2">2 personas</option>
                        <option value="3">3 personas</option>
                        <option value="4">4 personas</option>
                        <option value="5">5+ personas</option>
                    </select>
                </div>


                <!-- Botón Ver -->
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-cupra-solid w-100 py-3">RESERVA YA</button>
                </div>
            </div>

            <!-- Contador de mesas -->
            <div class="mt-4">
                <p class="text-white fw-bold" style="font-size: 14px; letter-spacing: 1px;">5 MESAS DISPONIBLES</p>
            </div>

        </div>
    </div>

</section>

<!-- Sección: Servicios Cupra (Carrusel 3D) -->
<section class="servicios-cupra bg-cupra-dark py-5">

    <!-- Título -->
    <div class="text-center mb-5 pt-5">
        <h2 class="font-exo text-white" style="font-size: 48px; font-weight: 300; letter-spacing: 3px;">
            SERVICIOS CUPRA
        </h2>
    </div>

    <!-- Carrusel 3D -->
    <div class="carousel-3d-container">
        <div class="carousel-3d-wrapper">

            <!-- Card 1 -->
            <div class="carousel-card-3d state-center" data-index="0">
                <img src="assets/images/home/Carrusel_1.webp" alt="Cupra Tasting">
                <div class="card-overlay">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="carousel-card-3d state-right" data-index="1">
                <img src="assets/images/home/Carrusel_2.webp" alt="Experiencia Signature">
                <div class="card-overlay">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="carousel-card-3d state-left" data-index="2">
                <img src="assets/images/home/Carrusel_3.webp" alt="Maestros del Sabor">
                <div class="card-overlay">
                    <i class="bi bi-arrow-left"></i>
                </div>
            </div>

        </div>

        <!-- Información del servicio activo -->
        <div class="carousel-info text-center mt-5">
            <h3 class="service-title font-exo text-white mb-3" style="font-size: 32px; font-weight: 600; letter-spacing: 2px;">
                CUPRA TASTING
            </h3>
            <p class="service-description text-white-50 mx-auto" style="max-width: 700px; font-size: 16px;">
                Vive una experiencia sensorial única con platos exclusivos y coctelería inspirada en el ADN CUPRA.
            </p>
        </div>

        <!-- Botón -->
        <div class="text-center mt-4">
            <button class="btn btn-cupra-solid px-5 py-3">MÁS INFORMACIÓN</button>
        </div>

        <!-- Indicadores -->
        <div class="carousel-indicators-3d d-flex justify-content-center gap-2 mt-5">
            <span class="indicator active" data-index="0"></span>
            <span class="indicator" data-index="1"></span>
            <span class="indicator" data-index="2"></span>
        </div>
    </div>

</section>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="assets/js/calendario.js"></script>