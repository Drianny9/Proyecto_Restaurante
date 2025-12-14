<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- CSS del nav para que el espaciador funcione -->
    <link rel="stylesheet" href="assets/css/nav.css">
</head>
<body>
    <!-- Header con el nav fijo -->
    <header>
        <?php include_once 'view/includes/nav.php' ?>
    </header>
    
    <!-- Espaciador para compensar el nav fijo -->
    <div class="nav-spacer"></div>
    
    <!-- Contenido principal -->
    <main>
        <?php include_once $view; ?>
    </main>
</body>
</html>