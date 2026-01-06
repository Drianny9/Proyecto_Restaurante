<?php
// Obtener la ruta base del proyecto
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta - CUPRA Eats</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/log.css">
</head>
<body class="login-page">
    
    <!-- Volver a la web -->
    <a href="<?php echo $basePath; ?>index.php" class="back-link">
        <i class="bi bi-arrow-left"></i> Volver a la web
    </a>

    <div class="login-container">
        <!-- Card de Registro -->
        <div class="login-card">
            <!-- Logo -->
            <div class="login-logo">
                <img src="<?php echo $basePath; ?>assets/images/logos/Logo_cupra_eats.svg" alt="CUPRA Eats">
            </div>

            <h2 class="login-title">CREAR CUENTA</h2>

            <!-- Mostrar errores si existen -->
            <?php if (isset($error)): ?>
                <div class="login-error">
                    <i class="bi bi-exclamation-circle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="?controller=Registro&action=procesarRegistro" class="login-form">
                <div class="form-group">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Tu nombre completo"
                           value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico *</label>
                    <input type="email" name="email" id="email" placeholder="tu@email.com"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Contraseña * (mínimo 6 caracteres)</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección (opcional)</label>
                    <input type="text" name="direccion" id="direccion" placeholder="Tu dirección"
                           value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono (opcional)</label>
                    <input type="tel" name="telefono" id="telefono" placeholder="600 000 000"
                           value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                </div>

                <button type="submit" class="btn-login">
                    REGISTRARSE
                </button>
            </form>

            <div class="login-footer">
                <p>¿Ya tienes cuenta? <a href="?controller=Log&action=verLogin">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>