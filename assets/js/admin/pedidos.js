//========================================
//MODULO DE PEDIDOS - Panel Admin (Clase)
//========================================

class PedidoAdmin {
    constructor() {
        this.pedidos = []; //Almacena todos los pedidos para filtrar
        this.pedidoActual = null;
        //Objeto para asignar un estilo CSS a cada estado
        this.estadoClases = {
            'pendiente': 'bg-warning text-dark',
            'preparando': 'bg-info',
            'listo': 'bg-primary',
            'entregado': 'bg-success',
            'cancelado': 'bg-danger'
        };
    }

    //========CARGAR PEDIDOS========
    async cargar() {
        try {
            const response = await fetch('api/pedidos.php');
            const data = await response.json();

            if (data.estado === 'Exito') {
                this.pedidos = data.data;
                this.mostrar(this.pedidos);
                this.cargarSelectUsuarios();
            } else {
                console.error('Error al cargar pedidos:', data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========CARGAR USUARIOS EN EL SELECT DEL FILTRO========
    //Usa Map + spread + map para obtener usuarios únicos (sin repetidos)
    cargarSelectUsuarios() {
        const select = document.getElementById('filtro-usuario');
        if (!select) return; //Si no encuentra el select la funcion para aqui

        //new Map guarda una lista de parejas [Clave, Valor] y no admite repetidos
        const usuariosUnicos = [...new Map(this.pedidos.map(p => [p.id_usuario, { id: p.id_usuario, nombre: p.nombre_usuario }])).values()];
        //Los ... son para convertir el resultado en un array normal para poder trabajar con el

        //Cuando borramos filtros pone la primera opcion
        select.innerHTML = '<option value="">Todos los usuarios</option>';

        //forEach para recorrer la lista y añadir cada opción
        usuariosUnicos.forEach(usuario => {
            const option = document.createElement('option');
            option.value = usuario.id; //Asignamos valor id para saber por quien filtrar
            option.textContent = usuario.nombre;
            select.appendChild(option); //Metemos la opcion dentro del select
        });
    }

    //========MOSTRAR PEDIDOS EN LA TABLA========
    //Usa forEach para recorrer y renderizar cada pedido
    mostrar(pedidos) {
        const tabla = document.getElementById('tabla-pedidos');
        if (!tabla) return;

        tabla.innerHTML = '';

        if (pedidos.length === 0) {
            tabla.innerHTML = '<tr><td colspan="6" class="text-center">No hay pedidos que coincidan con los filtros</td></tr>';
            return;
        }

        //forEach para recorrer y renderizar cada pedido
        pedidos.forEach(pedido => {
            const estadoClass = this.getEstadoClass(pedido.estado);
            const fecha = new Date(pedido.fecha).toLocaleString('es-ES');

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${pedido.id_pedido}</td>
                <td>${fecha}</td>
                <td>${pedido.nombre_usuario}</td>
                <td><span class="badge ${estadoClass}">${pedido.estado}</span></td>
                <td>${parseFloat(pedido.importe_total).toFixed(2)} €</td>
                <td class="acciones-btns">
                    <button class="btn btn-sm btn-info btn-ver-pedido" data-id="${pedido.id_pedido}" title="Ver detalles">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar-pedido" data-id="${pedido.id_pedido}" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tabla.appendChild(tr);
        });

        //Configurar eventos de botones después de renderizar
        this.configurarBotones();

        //Reaplicar moneda si estaba seleccionada
        if (window.aplicarMonedaActual) {
            window.aplicarMonedaActual();
        }
    }

    //========OBTENER CLASE CSS DEL ESTADO========
    //Creamos un objeto para asignar un estilo CSS a cada estado
    getEstadoClass(estado) {
        return this.estadoClases[estado] || 'bg-secondary';
    }

    //========FILTRAR PEDIDOS========
    //Usa filter + sort + spread para filtrar sin mutar el original
    filtrar() {
        const filtroUsuario = document.getElementById('filtro-usuario').value;
        const filtroFechaDesde = document.getElementById('filtro-fecha-desde').value;
        const filtroFechaHasta = document.getElementById('filtro-fecha-hasta').value;
        const filtroEstado = document.getElementById('filtro-estado').value;
        const ordenPrecio = document.getElementById('ordenar-precio').value;

        //... spread para crear una copia nueva de la lista sin modificar la original
        let pedidosFiltrados = [...this.pedidos];

        //Filtrar por usuario con filter
        if (filtroUsuario) {
            pedidosFiltrados = pedidosFiltrados.filter(p => p.id_usuario == filtroUsuario);
        }

        //Filtrar por fecha desde con filter
        if (filtroFechaDesde) {
            const fechaDesde = new Date(filtroFechaDesde);
            pedidosFiltrados = pedidosFiltrados.filter(p => new Date(p.fecha) >= fechaDesde);
        }

        //Filtrar por fecha hasta con filter
        if (filtroFechaHasta) {
            const fechaHasta = new Date(filtroFechaHasta);
            fechaHasta.setHours(23, 59, 59);
            pedidosFiltrados = pedidosFiltrados.filter(p => new Date(p.fecha) <= fechaHasta);
        }

        //Filtrar por estado con filter
        if (filtroEstado) {
            pedidosFiltrados = pedidosFiltrados.filter(p => p.estado === filtroEstado);
        }

        //Ordenar por precio con sort
        if (ordenPrecio === 'asc') {
            pedidosFiltrados.sort((a, b) => parseFloat(a.importe_total) - parseFloat(b.importe_total));
        } else if (ordenPrecio === 'desc') {
            pedidosFiltrados.sort((a, b) => parseFloat(b.importe_total) - parseFloat(a.importe_total));
        }

        this.mostrar(pedidosFiltrados);
    }

    //========LIMPIAR FILTROS========
    //Usa forEach para limpiar todos los campos de filtro a la vez
    limpiarFiltros() {
        ['filtro-usuario', 'filtro-fecha-desde', 'filtro-fecha-hasta', 'filtro-estado', 'ordenar-precio']
            .forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
        this.mostrar(this.pedidos);
    }

    //========VER DETALLES DEL PEDIDO========
    //Usa find para buscar el pedido por id
    ver(id) {
        const pedido = this.pedidos.find(p => p.id_pedido === id);
        if (!pedido) return;

        this.pedidoActual = pedido;

        document.getElementById('pedido-id-modal').textContent = pedido.id_pedido;
        document.getElementById('pedido-usuario-modal').textContent = pedido.nombre_usuario;
        document.getElementById('pedido-fecha-modal').textContent = new Date(pedido.fecha).toLocaleString('es-ES');
        document.getElementById('pedido-estado-modal').value = pedido.estado;
        document.getElementById('pedido-total-modal').textContent = parseFloat(pedido.importe_total).toFixed(2);

        //Mostrar líneas del pedido
        const tbody = document.getElementById('pedido-lineas-modal');
        tbody.innerHTML = '';

        if (pedido.lineas && pedido.lineas.length > 0) {
            //forEach para renderizar cada línea
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

    //========ACTUALIZAR ESTADO DEL PEDIDO========
    async actualizarEstado() {
        if (!this.pedidoActual) return;

        const nuevoEstado = document.getElementById('pedido-estado-modal').value;

        try {
            const response = await fetch('api/pedidos.php', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id_pedido: this.pedidoActual.id_pedido,
                    estado: nuevoEstado
                })
            });
            const data = await response.json();

            if (data.estado === 'Exito') {
                bootstrap.Modal.getInstance(document.getElementById('modalPedido')).hide();
                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========ELIMINAR PEDIDO========
    async eliminar(id) {
        if (!confirm('¿Estás seguro de que quieres eliminar este pedido? Esta acción no se puede deshacer.')) return;

        try {
            const response = await fetch(`api/pedidos.php?id=${id}`, {
                method: 'DELETE'
            });
            const data = await response.json();

            if (data.estado === 'Exito') {
                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========CONFIGURAR EVENTOS DE BOTONES========
    //Usa forEach para asignar eventos a todos los botones
    configurarBotones() {
        document.querySelectorAll('.btn-ver-pedido').forEach(btn => {
            btn.addEventListener('click', () => this.ver(parseInt(btn.dataset.id)));
        });

        document.querySelectorAll('.btn-eliminar-pedido').forEach(btn => {
            btn.addEventListener('click', () => this.eliminar(parseInt(btn.dataset.id)));
        });
    }

    //========INICIALIZAR EVENTOS DE PEDIDOS========
    //Usa forEach para asignar eventos a todos los filtros
    init() {
        //Eventos de filtros - forEach para asignar eventos a todos los filtros a la vez
        ['filtro-usuario', 'filtro-fecha-desde', 'filtro-fecha-hasta', 'filtro-estado', 'ordenar-precio']
            .forEach(id => {
                const elemento = document.getElementById(id);
                if (elemento) {
                    elemento.addEventListener('change', () => this.filtrar());
                }
            });

        //Botón limpiar filtros
        const btnLimpiar = document.getElementById('btn-limpiar-filtros');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', () => this.limpiarFiltros());
        }

        //Botón actualizar estado
        const btnActualizar = document.getElementById('btn-actualizar-estado-pedido');
        if (btnActualizar) {
            btnActualizar.addEventListener('click', () => this.actualizarEstado());
        }

        //Cargar pedidos al inicio
        this.cargar();
    }
}

//====INSTANCIA GLOBAL====
const pedidoAdmin = new PedidoAdmin();

//====FUNCIONES WRAPPER GLOBALES====
//Para mantener compatibilidad con inicializacion.js y otros scripts
function cargarPedidos() { pedidoAdmin.cargar(); }
function cargarSelectUsuarios() { pedidoAdmin.cargarSelectUsuarios(); }
function mostrarPedidos(pedidos) { pedidoAdmin.mostrar(pedidos); }
function getEstadoClass(estado) { return pedidoAdmin.getEstadoClass(estado); }
function filtrarPedidos() { pedidoAdmin.filtrar(); }
function limpiarFiltros() { pedidoAdmin.limpiarFiltros(); }
function verPedido(id) { pedidoAdmin.ver(id); }
function actualizarEstadoPedido() { pedidoAdmin.actualizarEstado(); }
function eliminarPedido(id) { pedidoAdmin.eliminar(id); }
function inicializarPedidos() { pedidoAdmin.init(); }
