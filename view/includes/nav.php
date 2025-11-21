<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <!--logo del restaurante-->
        <a class="navbar-brand fw-bold fs-3" href="../index.php">
            <img src="/DAW 2/Proyecto_Restaurante/assets/images/Logo cupra_eats.png" alt="Logo" style="height: 200px;">
        </a>

        <!--boton hamburguesa-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> 
            <span class="navbar-toggler-icon"></span>
        </button>

        <!--menu de navegacion-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="encuentranos.php">Encuéntranos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="configurador.php">Configurador</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cookies.php">Cookies</a>
                </li>
            </ul>

            <!--seccion de usuario y acceso-->
            <div class="d-flex align-items-center gap-3">
                <a href="accesibilidad.php" class="text-white">
                    <i class="bi bi-universal-access fs-4"></i>
                </a>
                <a href="login.php" class="text-white">
                    <i class="bi bi-person fs-4"></i>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </div>
    </div>
</nav>