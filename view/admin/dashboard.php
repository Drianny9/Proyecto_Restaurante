<link rel="stylesheet" href="assets/css/admin.css">

<main class="admin-container">
    
    <!-- Navegación lateral -->
    <aside class="admin-sidebar">
        <h2>Panel Admin</h2>
        <nav class="admin-nav">
            <button class="menu-btn active" data-target="usuarios">
                <i class="bi bi-people"></i> Usuarios
            </button>
            <button class="menu-btn" data-target="productos">
                <i class="bi bi-box"></i> Productos
            </button>
            <button class="menu-btn" data-target="categorias">
                <i class="bi bi-tags"></i> Categorías
            </button>
            <button class="menu-btn" data-target="pedidos">
                <i class="bi bi-cart"></i> Pedidos
            </button>
        </nav>
    </aside>

    <!-- Contenido principal -->
    <div class="admin-content">
        
        <!-- SECCIÓN USUARIOS -->
        <section id="usuarios" class="content-section active-section">
            <div class="section-header">
                <h1>Gestión de Usuarios</h1>
                <button class="btn btn-primary" onclick="abrirModalNuevoUsuario()">
                    <i class="bi bi-plus-circle"></i> Nuevo Usuario
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= $usuario->getId_usuario() ?></td>
                                    <td><?= $usuario->getNombre() ?></td>
                                    <td><?= $usuario->getEmail() ?></td>
                                    <td><?= $usuario->getRol() ?></td>
                                    <td><?= $usuario->getTelefono() ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editarUsuario(<?= $usuario->getId_usuario() ?>)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(<?= $usuario->getId_usuario() ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No hay usuarios</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECCIÓN PRODUCTOS -->
        <section id="productos" class="content-section">
            <div class="section-header">
                <h1>Gestión de Productos</h1>
                <button class="btn btn-primary" onclick="abrirModalNuevoProducto()">
                    <i class="bi bi-plus-circle"></i> Nuevo Producto
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td><?= $producto->getId_producto() ?></td>
                                    <td><?= $producto->getNombre() ?></td>
                                    <td><?= $producto->getId_categoria() ?></td>
                                    <td><?= number_format($producto->getPrecio_base(), 2) ?> €</td>
                                    <td>
                                        <img src="assets/images/productos/<?= $producto->getImagen() ?>" 
                                             alt="<?= $producto->getNombre() ?>" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editarProducto(<?= $producto->getId_producto() ?>)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="eliminarProducto(<?= $producto->getId_producto() ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No hay productos</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECCIÓN CATEGORÍAS -->
        <section id="categorias" class="content-section">
            <div class="section-header">
                <h1>Gestión de Categorías</h1>
                <button class="btn btn-primary" onclick="abrirModalNuevaCategoria()">
                    <i class="bi bi-plus-circle"></i> Nueva Categoría
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categorias)): ?>
                            <?php foreach ($categorias as $categoria): ?>
                                <tr>
                                    <td><?= $categoria->getIdCategoria() ?></td>
                                    <td><?= $categoria->getNombre() ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" onclick="editarCategoria(<?= $categoria->getIdCategoria() ?>)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="eliminarCategoria(<?= $categoria->getIdCategoria() ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3">No hay categorías</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECCIÓN PEDIDOS -->
        <section id="pedidos" class="content-section">
            <div class="section-header">
                <h1>Gestión de Pedidos</h1>
            </div>
            <p>Aquí irán los pedidos...</p>
        </section>

    </div>
</main>

<!-- JavaScript para cambiar secciones -->
<script src="assets/js/admin.js"></script>