<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cupra Eats - Restaurante</title>
    
    <!-- Google Fonts: Exo 2 y Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700;900&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- CSS del Hero Section -->
    <link rel="stylesheet" href="assets/css/hero.css">
</head>
<body>
    <!-- Header con el nav (transparente en home, fijo en otras páginas) -->
    <?php if (!isset($_GET['controller']) || $_GET['controller'] == 'Home'): ?>
        <!-- En home el nav va dentro del hero -->
    <?php else: ?>
        <!-- En otras páginas el nav va aquí arriba -->
        <header>
            <?php include_once 'view/includes/nav.php' ?>
        </header>
        <!-- Espaciador para compensar el nav fijo -->
        <div class="nav-spacer"></div>
    <?php endif; ?>
    
    <!-- Contenido principal -->
    <main>
        <?php include_once $view; ?>
    </main>
    
    <!-- Script global del carrito (localStorage) -->
    <script src="assets/js/carrito.js"></script>
    
    <!-- Script del carrusel 3D -->
    <script src="assets/js/carousel3d.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>