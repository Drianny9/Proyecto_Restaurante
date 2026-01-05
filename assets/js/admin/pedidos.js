// ========================================
// MODULO DE PEDIDOS - Panel Admin
// ========================================

let todosLosPedidos = []; // Almacena todos los pedidos para filtrar

// Cargar pedidos en la tabla
function cargarPedidos() {
    fetch('api/pedidos.php')
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                todosLosPedidos = data.data;
                mostrarPedidos(todosLosPedidos);
                cargarSelectUsuarios();
            } else {
                console.error('Error al cargar pedidos:', data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Cargar usuarios en el select de filtro
function cargarSelectUsuarios() {
    const select = document.getElementById('filtro-usuario');
    if (!select) return;
    
    // Obtener usuarios únicos de los pedidos
    const usuariosUnicos = [...new Map(todosLosPedidos.map(p => [p.id_usuario, { id: p.id_usuario, nombre: p.nombre_usuario }])).values()];
    
    // Mantener la primera opción
    select.innerHTML = '<option value="">Todos los usuarios</option>';
    
    usuariosUnicos.forEach(usuario => {
        const option = document.createElement('option');
        option.value = usuario.id;
        option.textContent = usuario.nombre;
        select.appendChild(option);
    });
}

// Mostrar pedidos en la tabla
function mostrarPedidos(pedidos) {
    const tabla = document.getElementById('tabla-pedidos');
    if (!tabla) return;
    
    tabla.innerHTML = '';
    
    if (pedidos.length === 0) {
        tabla.innerHTML = '<tr><td colspan="6" class="text-center">No hay pedidos que coincidan con los filtros</td></tr>';
        return;
    }
    
    pedidos.forEach(pedido => {
        const estadoClass = getEstadoClass(pedido.estado);
        const fecha = new Date(pedido.fecha).toLocaleString('es-ES');
        
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${pedido.id_pedido}</td>
            <td>${fecha}</td>
            <td>${pedido.nombre_usuario}</td>
            <td><span class="badge ${estadoClass}">${pedido.estado}</span></td>
            <td>${parseFloat(pedido.importe_total).toFixed(2)} €</td>
            <td class="acciones-btns">
                <button class="btn btn-sm btn-info" onclick="verPedido(${pedido.id_pedido})" title="Ver detalles">
                    <i class="bi bi-eye"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarPedido(${pedido.id_pedido})" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tabla.appendChild(tr);
    });
}

// Obtener clase CSS según estado
function getEstadoClass(estado) {
    const clases = {
        'pendiente': 'bg-warning text-dark',
        'preparando': 'bg-info',
        'listo': 'bg-primary',
        'entregado': 'bg-success',
        'cancelado': 'bg-danger'
    };
    return clases[estado] || 'bg-secondary';
}

// Filtrar pedidos
function filtrarPedidos() {
    const filtroUsuario = document.getElementById('filtro-usuario').value;
    const filtroFechaDesde = document.getElementById('filtro-fecha-desde').value;
    const filtroFechaHasta = document.getElementById('filtro-fecha-hasta').value;
    const filtroEstado = document.getElementById('filtro-estado').value;
    const ordenPrecio = document.getElementById('ordenar-precio').value;
    
    let pedidosFiltrados = [...todosLosPedidos];
    
    // Filtrar por usuario
    if (filtroUsuario) {
        pedidosFiltrados = pedidosFiltrados.filter(p => p.id_usuario == filtroUsuario);
    }
    
    // Filtrar por fecha desde
    if (filtroFechaDesde) {
        const fechaDesde = new Date(filtroFechaDesde);
        pedidosFiltrados = pedidosFiltrados.filter(p => new Date(p.fecha) >= fechaDesde);
    }
    
    // Filtrar por fecha hasta
    if (filtroFechaHasta) {
        const fechaHasta = new Date(filtroFechaHasta);
        fechaHasta.setHours(23, 59, 59);
        pedidosFiltrados = pedidosFiltrados.filter(p => new Date(p.fecha) <= fechaHasta);
    }
    
    // Filtrar por estado
    if (filtroEstado) {
        pedidosFiltrados = pedidosFiltrados.filter(p => p.estado === filtroEstado);
    }
    
    // Ordenar por precio
    if (ordenPrecio === 'asc') {
        pedidosFiltrados.sort((a, b) => parseFloat(a.importe_total) - parseFloat(b.importe_total));
    } else if (ordenPrecio === 'desc') {
        pedidosFiltrados.sort((a, b) => parseFloat(b.importe_total) - parseFloat(a.importe_total));
    }
    
    mostrarPedidos(pedidosFiltrados);
}

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('filtro-usuario').value = '';
    document.getElementById('filtro-fecha-desde').value = '';
    document.getElementById('filtro-fecha-hasta').value = '';
    document.getElementById('filtro-estado').value = '';
    document.getElementById('ordenar-precio').value = '';
    mostrarPedidos(todosLosPedidos);
}

// Ver detalles del pedido
let pedidoActual = null;
function verPedido(id) {
    const pedido = todosLosPedidos.find(p => p.id_pedido === id);
    if (!pedido) return;
    
    pedidoActual = pedido;
    
    document.getElementById('pedido-id-modal').textContent = pedido.id_pedido;
    document.getElementById('pedido-usuario-modal').textContent = pedido.nombre_usuario;
    document.getElementById('pedido-fecha-modal').textContent = new Date(pedido.fecha).toLocaleString('es-ES');
    document.getElementById('pedido-estado-modal').value = pedido.estado;
    document.getElementById('pedido-total-modal').textContent = parseFloat(pedido.importe_total).toFixed(2);
    
    // Mostrar líneas del pedido
    const tbody = document.getElementById('pedido-lineas-modal');
    tbody.innerHTML = '';
    
    if (pedido.lineas && pedido.lineas.length > 0) {
        pedido.lineas.forEach(linea => {
            const subtotal = linea.cantidad * linea.precio_unidad;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${linea.nombre_producto}</td>
                <td>${linea.cantidad}</td>
                <td>${parseFloat(linea.precio_unidad).toFixed(2)} €</td>
                <td>${subtotal.toFixed(2)} €</td>
            `;
            tbody.appendChild(tr);
        });
    } else {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay productos en este pedido</td></tr>';
    }
    
    const modal = new bootstrap.Modal(document.getElementById('modalPedido'));
    modal.show();
}

// Actualizar estado del pedido
function actualizarEstadoPedido() {
    if (!pedidoActual) return;
    
    const nuevoEstado = document.getElementById('pedido-estado-modal').value;
    
    fetch('api/pedidos.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            id_pedido: pedidoActual.id_pedido,
            estado: nuevoEstado
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'Exito') {
            bootstrap.Modal.getInstance(document.getElementById('modalPedido')).hide();
            cargarPedidos();
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => console.error('Error:', error));
}

// Eliminar pedido
function eliminarPedido(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este pedido? Esta acción no se puede deshacer.')) {
        fetch(`api/pedidos.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                cargarPedidos();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Inicializar eventos de pedidos
function inicializarPedidos() {
    // Eventos de filtros
    const filtros = ['filtro-usuario', 'filtro-fecha-desde', 'filtro-fecha-hasta', 'filtro-estado', 'ordenar-precio'];
    filtros.forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) {
            elemento.addEventListener('change', filtrarPedidos);
        }
    });
    
    // Botón limpiar filtros
    const btnLimpiar = document.getElementById('btn-limpiar-filtros');
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', limpiarFiltros);
    }
    
    // Botón actualizar estado
    const btnActualizar = document.getElementById('btn-actualizar-estado-pedido');
    if (btnActualizar) {
        btnActualizar.addEventListener('click', actualizarEstadoPedido);
    }
    
    // Cargar pedidos al inicio
    cargarPedidos();
}
