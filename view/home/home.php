<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupra Eats - Home</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>
    <!-- Incluir Navbar -->
    <?php include_once 'view/includes/nav.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="hero-subtitle">CUPRA</p>
                        <h1 class="hero-title">BORN</h1>
                        <p class="hero-description">
                            El sabor que redefine la grandeza. Una nueva era<br>
                            gastronómica inspirada en la energía y el diseño.
                        </p>
                        <div class="hero-price">
                            <span class="price-label">POR</span>
                            <span class="price-amount">XX €</span>
                        </div>
                        <div class="hero-buttons">
                            <a href="#encuentranos" class="btn btn-outline-light btn-lg me-3">ENCUÉNTRANOS</a>
                            <a href="#configurador" class="btn btn-light btn-lg">CONFIGURADOR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carrusel de productos -->
    <section class="products-carousel">
        <div class="carousel-container">
            <div class="carousel-track" id="carouselTrack">
                <!-- Item 1 -->
                <div class="carousel-item">
                    <div class="product-card">
                        <div class="product-image">
                            <!-- Placeholder para imagen -->
                            <div class="image-placeholder"></div>
                        </div>
                        <div class="product-label">FORMENTOR</div>
                    </div>
                </div>
                
                <!-- Item 2 -->
                <div class="carousel-item">
                    <div class="product-card">
                        <div class="product-image">
                            <div class="image-placeholder"></div>
                        </div>
                        <div class="product-label">FORMENTOR</div>
                    </div>
                </div>
                
                <!-- Item 3 -->
                <div class="carousel-item">
                    <div class="product-card">
                        <div class="product-image">
                            <div class="image-placeholder"></div>
                        </div>
                        <div class="product-label">FORMENTOR</div>
                    </div>
                </div>
                
                <!-- Item 4 -->
                <div class="carousel-item">
                    <div class="product-card">
                        <div class="product-image">
                            <div class="image-placeholder"></div>
                        </div>
                        <div class="product-label">FORMENTOR</div>
                    </div>
                </div>
                
                <!-- Item 5 -->
                <div class="carousel-item">
                    <div class="product-card">
                        <div class="product-image">
                            <div class="image-placeholder"></div>
                        </div>
                        <div class="product-label">FORMENTOR</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom JS -->
    <script src="assets/js/carousel.js"></script>
</body>
</html>