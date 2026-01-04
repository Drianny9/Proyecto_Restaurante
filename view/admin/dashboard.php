<link rel="stylesheet" href="assets/css/admin.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

<main class="admin-container admin-page">
    
    <!-- Navegacion lateral -->
    <aside class="admin-sidebar">
        <h2>Panel Admin</h2>
        <nav class="admin-nav">
            <button class="menu-btn" data-target="usuarios">
                <i class="bi bi-people"></i> Usuarios
            </button>
            <button class="menu-btn active" data-target="productos">
                <i class="bi bi-box"></i> Productos
            </button>
            <button class="menu-btn" data-target="categorias">
                <i class="bi bi-tags"></i> Categorias
            </button>
            <button class="menu-btn" data-target="pedidos">
                <i class="bi bi-cart"></i> Pedidos
            </button>
        </nav>
        
        <!-- Separador y botones de navegación -->
        <div class="sidebar-footer">
            <hr class="sidebar-divider">
            <a href="?controller=Home&action=verHome" class="sidebar-link">
                <i class="bi bi-arrow-left"></i> Volver a la web
            </a>
            <a href="?controller=Usuario&action=logout" class="sidebar-link sidebar-link-danger">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
        </div>
    </aside>

    <!-- Contenido principal -->
    <div class="admin-content">
        
        <!-- SECCION USUARIOS -->
        <section id="usuarios" class="content-section">
            <div class="section-header">
                <h1>Gestion de Usuarios</h1>
                <div class="section-header-buttons">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-currency-exchange"></i> Conversor
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-moneda="EUR"><i class="bi bi-currency-euro"></i> Euros (EUR)</a></li>
                            <li><a class="dropdown-item" href="#" data-moneda="USD"><i class="bi bi-currency-dollar"></i> Dólares (USD)</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary" id="btn-nuevo-usuario">
                        <i class="bi bi-plus-circle"></i> Nuevo Usuario
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Telefono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-usuarios">
                        <!-- Los datos se cargan con JavaScript desde la API -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECCION PRODUCTOS -->
        <section id="productos" class="content-section active-section">
            <div class="section-header">
                <h1>Gestion de Productos</h1>
                <div class="section-header-buttons">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-currency-exchange"></i> Conversor
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-moneda="EUR"><i class="bi bi-currency-euro"></i> Euros (EUR)</a></li>
                            <li><a class="dropdown-item" href="#" data-moneda="USD"><i class="bi bi-currency-dollar"></i> Dólares (USD)</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary" id="btn-nuevo-producto">
                        <i class="bi bi-plus-circle"></i> Nuevo Producto
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-productos">
                        <!-- Los datos se cargan con JavaScript desde la API -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECCION CATEGORIAS -->
        <section id="categorias" class="content-section">
            <div class="section-header">
                <h1>Gestion de Categorias</h1>
                <div class="section-header-buttons">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-currency-exchange"></i> Conversor
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-moneda="EUR"><i class="bi bi-currency-euro"></i> Euros (EUR)</a></li>
                            <li><a class="dropdown-item" href="#" data-moneda="USD"><i class="bi bi-currency-dollar"></i> Dólares (USD)</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary" id="btn-nueva-categoria">
                        <i class="bi bi-plus-circle"></i> Nueva Categoria
                    </button>
                </div>
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
                    <tbody id="tabla-categorias">
                        <!-- Los datos se cargan con JavaScript desde la API -->
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECCION PEDIDOS -->
        <section id="pedidos" class="content-section">
            <div class="section-header">
                <h1>Gestion de Pedidos</h1>
                <div class="section-header-buttons">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-currency-exchange"></i> Conversor
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-moneda="EUR"><i class="bi bi-currency-euro"></i> Euros (EUR)</a></li>
                            <li><a class="dropdown-item" href="#" data-moneda="USD"><i class="bi bi-currency-dollar"></i> Dólares (USD)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-pedidos">
                        <!-- Los datos se cargan con JavaScript desde la API -->
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</main>

<!-- MODAL PARA CREAR/EDITAR PRODUCTO -->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProductoTitulo">Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formProducto">
                    <input type="hidden" id="producto-id">
                    
                    <div class="mb-3">
                        <label for="producto-nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="producto-nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="producto-descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="producto-descripcion" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="producto-categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="producto-categoria" required>
                            <option value="">Selecciona una categoría</option>
                            <option value="1">Entrantes</option>
                            <option value="2">Principales</option>
                            <option value="3">Postres</option>
                            <option value="4">Bebidas</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="producto-precio" class="form-label">Precio (€)</label>
                        <input type="number" step="0.01" class="form-control" id="producto-precio" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="producto-imagen" class="form-label">Imagen (nombre del archivo)</label>
                        <input type="text" class="form-control" id="producto-imagen" placeholder="ejemplo.png">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-producto">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript modular para el panel admin -->
<!-- Primero cargamos los módulos, luego inicializacion.js que los inicializa -->
<script src="assets/js/admin/productos.js"></script>
<script src="assets/js/admin/lineaPedido.js"></script>
<script src="assets/js/admin/inicializacion.js"></script>
<script src="assets/js/admin/conversor.js"></script>