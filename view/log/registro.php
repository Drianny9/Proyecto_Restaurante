<head>
    <link rel="stylesheet" href="assets/css/log.css">
</head>

<body>
    <?php include_once 'view/includes/nav.php'; ?>

    <section class="form-login">
        <h2 class="text-center mb-4">Crear cuenta</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="post" action="?controller=Registro&action=procesarRegistro">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo *</label>
                <input type="text" name="nombre" class="form-control" id="nombre" 
                       value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico *</label>
                <input type="email" name="email" class="form-control" id="email" 
                       placeholder="name@example.com"
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña * (mínimo 6 caracteres)</label>
                <input type="password" name="contraseña" class="form-control" id="contraseña" required>
            </div>
            
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección (opcional)</label>
                <input type="text" name="direccion" class="form-control" id="direccion"
                       value="<?php echo isset($_POST['direccion']) ? htmlspecialchars($_POST['direccion']) : ''; ?>">
            </div>
            
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono (opcional)</label>
                <input type="tel" name="telefono" class="form-control" id="telefono"
                       value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
            </div>
            
            <button type="submit" class="btn btn-primary w-100 mb-3">Registrarse</button>
            
            <p class="text-center">
                ¿Ya tienes cuenta? 
                <a href="?controller=Log&action=verLogin">Iniciar sesión</a>
            </p>
        </form>
    </section>
</body>