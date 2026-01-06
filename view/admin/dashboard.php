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
            <button class="menu-btn" data-target="logs">
                <i class="bi bi-clock-history"></i> Historial Logs
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
            <a href="?controller=Log&action=cerrarSesion" class="sidebar-link sidebar-link-danger">
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
            
            <!-- Template: Fila de producto -->
            <template id="template-fila-producto">
                <tr>
                    <td class="producto-id"></td>
                    <td class="producto-nombre"></td>
                    <td class="producto-descripcion"></td>
                    <td class="precio-display" data-precio-base=""></td>
                    <td class="producto-imagen"></td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-editar-producto">Editar</button>
                        <button class="btn btn-sm btn-danger btn-eliminar-producto">Eliminar</button>
                    </td>
                </tr>
            </template>
        </section>

        <!-- SECCION LOGS -->
        <section id="logs" class="content-section">
            <div class="section-header">
                <h1>Historial de Logs</h1>
                <div class="section-header-buttons">
                    <button class="btn btn-danger" id="btn-limpiar-logs">
                        <i class="bi bi-trash"></i> Limpiar Logs
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Acción</th>
                            <th>Fecha y Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-logs">
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
            
            <!-- Filtros de pedidos -->
            <div class="filtros-pedidos mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="filtro-usuario" class="form-label">Usuario</label>
                        <select class="form-select" id="filtro-usuario">
                            <option value="">Todos los usuarios</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filtro-fecha-desde" class="form-label">Desde</label>
                        <input type="date" class="form-control" id="filtro-fecha-desde">
                    </div>
                    <div class="col-md-2">
                        <label for="filtro-fecha-hasta" class="form-label">Hasta</label>
                        <input type="date" class="form-control" id="filtro-fecha-hasta">
                    </div>
                    <div class="col-md-2">
                        <label for="filtro-estado" class="form-label">Estado</label>
                        <select class="form-select" id="filtro-estado">
                            <option value="">Todos</option>
                            <option value="pendiente">Pendiente</option>
                            <option value="preparando">Preparando</option>
                            <option value="listo">Listo</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="ordenar-precio" class="form-label">Ordenar por precio</label>
                        <select class="form-select" id="ordenar-precio">
                            <option value="">Sin ordenar</option>
                            <option value="asc">Menor a mayor</option>
                            <option value="desc">Mayor a menor</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-secondary w-100" id="btn-limpiar-filtros" title="Limpiar filtros">
                            <i class="bi bi-x-circle"></i>
                        </button>
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

<!-- MODAL PARA CREAR/EDITAR USUARIO -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUsuarioTitulo">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formUsuario">
                    <input type="hidden" id="usuario-id">
                    
                    <div class="mb-3">
                        <label for="usuario-nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="usuario-nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="usuario-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="usuario-email" required>
                    </div>
                    
                    <div class="mb-3" id="campo-password">
                        <label for="usuario-password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="usuario-password">
                        <small class="text-muted">Dejar vacío para mantener la contraseña actual (al editar)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="usuario-telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="usuario-telefono">
                    </div>
                    
                    <div class="mb-3">
                        <label for="usuario-direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="usuario-direccion">
                    </div>
                    
                    <div class="mb-3">
                        <label for="usuario-rol" class="form-label">Rol</label>
                        <select class="form-select" id="usuario-rol" required>
                            <option value="user">Usuario</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btn-guardar-usuario">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA VER DETALLES DEL PEDIDO -->
<div class="modal fade" id="modalPedido" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Pedido #<span id="pedido-id-modal"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Usuario:</strong> <span id="pedido-usuario-modal"></span>
                    </div>
                    <div class="col-md-4">
                        <strong>Fecha:</strong> <span id="pedido-fecha-modal"></span>
                    </div>
                    <div class="col-md-4">
                        <strong>Estado:</strong> 
                        <select class="form-select form-select-sm d-inline-block w-auto" id="pedido-estado-modal">
                            <option value="pendiente">Pendiente</option>
                            <option value="preparando">Preparando</option>
                            <option value="listo">Listo</option>
                            <option value="entregado">Entregado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                </div>
                
                <h6 class="mb-3">Productos del pedido:</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Ud.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="pedido-lineas-modal">
                    </tbody>
                </table>
                
                <div class="text-end">
                    <h5>Total: <span id="pedido-total-modal"></span> €</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar-estado-pedido">Guardar Estado</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript modular para el panel admin -->
<!-- Primero cargamos los módulos, luego inicializacion.js que los inicializa -->
<script src="assets/js/admin/productos.js"></script>
<script src="assets/js/admin/usuarios.js"></script>
<script src="assets/js/admin/pedidos.js"></script>
<script src="assets/js/admin/logs.js"></script>
<script src="assets/js/admin/lineaPedido.js"></script>
<script src="assets/js/admin/inicializacion.js"></script>
<script src="assets/js/admin/conversor.js"></script>