<head>
    <link rel="stylesheet" href="assets/css/log.css">
</head>

<body>
    <?php include_once 'view/includes/nav.php'; ?>

    <section class="form-login">
        <form method="post" action="?controller=Log&action=procesarLogin">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">ID o Correo electrónico</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="contraseña" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
        <!--Mensaje de error-->
        <?php if (isset($error)): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
    </section>
</body>