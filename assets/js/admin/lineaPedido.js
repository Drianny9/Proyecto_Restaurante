//========================================
//MODULO DE LINEAS PEDIDO - Panel Admin (Clase)
//========================================

class LineaPedidoAdmin {
    constructor() {
        this.lineas = [];
    }

    //========CARGAR LINEAS DE PEDIDO========
    async cargar(idPedido = null) {
        let url = 'api/lineas_pedido.php';
        if (idPedido) {
            url += '?id_pedido=' + idPedido;
        }

        try {
            const response = await fetch(url); //Obtengo el url construido
            const data = await response.json();

            if (data.estado === 'Exito') {
                this.lineas = data.data;
                this.mostrar(this.lineas);
            } else {
                console.error('Error al cargar líneas de pedido', data.mensaje);
            }
        } catch (error) {
            console.error('Error en la petición:', error);
        }
    }

    //========MOSTRAR LINEAS EN LA TABLA========
    //Usa forEach para recorrer y renderizar cada línea
    mostrar(lineas) {
        const tbody = document.getElementById('tabla-lineas-pedido');
        if (!tbody) return; //Ponemos el return para que salga de la funcion si no encuentra tbody

        tbody.innerHTML = '';

        if (lineas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay líneas de pedido</td></tr>';
            return;
        }

        //forEach para recorrer y renderizar cada línea
        lineas.forEach(linea => {
            const fila = document.createElement('tr');
            const subtotal = (Number(linea.precio_unidad) * Number(linea.cantidad)).toFixed(2);
            fila.innerHTML = `
                <td>${linea.id_linea}</td>
                <td>${linea.id_pedido}</td>
                <td>${linea.id_producto}</td>
                <td>${Number(linea.precio_unidad).toFixed(2)} €</td>
                <td>${linea.cantidad}</td>
                <td>${subtotal} €</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-editar-linea" data-id="${linea.id_linea}">
                        Editar
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar-linea" data-id="${linea.id_linea}">
                        Eliminar
                    </button>
                </td>
            `;
            tbody.appendChild(fila);
        });

        this.configurarBotones();
    }

    //========CONFIGURAR BOTONES========
    //Usa forEach para asignar eventos a todos los botones
    configurarBotones() {
        document.querySelectorAll('.btn-editar-linea').forEach(boton => {
            boton.addEventListener('click', () => {
                const id = boton.getAttribute('data-id');
                this.abrirModalEditar(id);
            });
        });

        document.querySelectorAll('.btn-eliminar-linea').forEach(boton => {
            boton.addEventListener('click', () => {
                const id = boton.getAttribute('data-id');
                this.eliminar(id); //Llamamos a la funcion para eliminar el pedido
            });
        });
    }

    //========ELIMINAR LINEA DE PEDIDO========
    async eliminar(id) {
        if (!confirm('¿Estás seguro de eliminar esta línea de pedido?')) {
            return;
        }

        try {
            const response = await fetch('api/lineas_pedido.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });
            const data = await response.json();

            if (data.estado === 'Exito') {
                alert(data.mensaje);
                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al eliminar línea de pedido');
        }
    }

    //========ABRIR MODAL PARA NUEVA LINEA========
    abrirModalNueva() {
        const form = document.getElementById('formLineaPedido');
        if (form) {
            form.reset(); //con .reset eliminamos los campos introducidos anteriormente para que no se guarden
        }
        document.getElementById('linea-id').value = ''; //Vaciamos el id para que en la nueva no se mantenga el valor anterior

        document.getElementById('modalLineaTitulo').textContent = 'Nueva Línea de Pedido';

        //Llamamos a bootstrap para hacer una ventana interactiva, ya tiene funciones por defecto
        const modal = new bootstrap.Modal(document.getElementById('modalLineaPedido'));
        modal.show(); //con .show() mostramos el modal pero ademas se encarga de añadirle CSS
    }

    //========ABRIR MODAL PARA EDITAR LINEA========
    async abrirModalEditar(id) {
        try {
            const response = await fetch('api/lineas_pedido.php?id=' + id); //Necesitamos id para abrir la linea de pedido que seleccionamos
            const data = await response.json();

            if (data.estado === 'Exito') {
                const linea = data.data;

                document.getElementById('linea-id').value = linea.id_linea;
                document.getElementById('linea-pedido').value = linea.id_pedido;
                document.getElementById('linea-producto').value = linea.id_producto;
                document.getElementById('linea-precio').value = linea.precio_unidad;
                document.getElementById('linea-cantidad').value = linea.cantidad;
                document.getElementById('linea-oferta').value = linea.id_oferta || '';

                document.getElementById('modalLineaTitulo').textContent = 'Editar Línea de Pedido';

                const modal = new bootstrap.Modal(document.getElementById('modalLineaPedido'));
                modal.show();
            } else {
                alert('Error al cargar línea de pedido');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cargar línea de pedido');
        }
    }

    //========GUARDAR LINEA (CREAR O ACTUALIZAR)========
    async guardar() {
        const id = document.getElementById('linea-id').value;
        const id_pedido = document.getElementById('linea-pedido').value;
        const id_producto = document.getElementById('linea-producto').value;
        const precio_unidad = document.getElementById('linea-precio').value;
        const cantidad = document.getElementById('linea-cantidad').value;
        const id_oferta = document.getElementById('linea-oferta').value;

        //Validar campos requeridos
        if (!id_pedido || !id_producto || !precio_unidad || !cantidad) {
            alert('Por favor, rellena todos los campos obligatorios');
            return;
        }

        const datos = {
            id_pedido: parseInt(id_pedido),
            id_producto: parseInt(id_producto),
            precio_unidad: parseFloat(precio_unidad),
            cantidad: parseInt(cantidad),
            id_oferta: id_oferta ? parseInt(id_oferta) : null
        };

        let metodo = 'POST';
        if (id) {
            metodo = 'PUT';
            datos.id = parseInt(id);
        }

        try {
            const response = await fetch('api/lineas_pedido.php', {
                method: metodo,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            });
            const data = await response.json();

            if (data.estado === 'Exito') {
                alert(data.mensaje);

                const modal = bootstrap.Modal.getInstance(document.getElementById('modalLineaPedido'));
                modal.hide();

                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al guardar línea de pedido');
        }
    }

    //========INICIALIZACIÓN DE LINEAS PEDIDO========
    init() {
        const btnNuevaLinea = document.getElementById('btn-nueva-linea');
        if (btnNuevaLinea) {
            btnNuevaLinea.addEventListener('click', () => this.abrirModalNueva());
        }

        const btnGuardar = document.getElementById('btn-guardar-linea');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => this.guardar());
        }

        //No cargamos automáticamente, se carga cuando se navega a la sección
    }
}

//====INSTANCIA GLOBAL====
const lineaPedidoAdmin = new LineaPedidoAdmin();

//====FUNCIONES WRAPPER GLOBALES====
//Para mantener compatibilidad con inicializacion.js y otros scripts
function cargarLineasPedido(idPedido) { lineaPedidoAdmin.cargar(idPedido); }
function mostrarLineasPedido(lineas) { lineaPedidoAdmin.mostrar(lineas); }
function eliminarLineaPedido(id) { lineaPedidoAdmin.eliminar(id); }
function initLineasPedido() { lineaPedidoAdmin.init(); }
