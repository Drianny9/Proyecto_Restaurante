<!-- Incluimos el nav -->
<head>
    <link rel="stylesheet" href="assets/css/log.css">
</head>
<body>
    <?php include_once 'view/includes/nav.php'; ?>

    <section class="form-login">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Nombre</label>
            <input type="nombre" class="form-control" id="exampleFormControlInput1" placeholder="Nombre">
            <label for="exampleFormControlTextarea1" class="form-label">Apellidos</label>
            <input type="apellidos" class="form-control" id="exampleFormControlInput1" placeholder="Apellidos">
        </div>
    </section>
</body>