//====LINEAS PEDIDO - Gestión CRUD====

//========CARGAR LINEAS DE PEDIDO========
function cargarLineasPedido(idPedido = null) {
    let url = 'api/lineas_pedido.php';
    if (idPedido) {
        url += '?id_pedido=' + idPedido;
    }
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                mostrarLineasPedido(data.data);
            } else {
                console.error('Error al cargar líneas de pedido', data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
}

//========MOSTRAR LINEAS EN LA TABLA========
function mostrarLineasPedido(lineas) {
    const tbody = document.getElementById('tabla-lineas-pedido');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (lineas.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center">No hay líneas de pedido</td></tr>';
        return;
    }
    
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
    
    configurarBotonesLineasPedido();
}

//========CONFIGURAR BOTONES DE LINEAS========
function configurarBotonesLineasPedido() {
    document.querySelectorAll('.btn-editar-linea').forEach(boton => {
        boton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            abrirModalEditarLinea(id);
        });
    });
    
    document.querySelectorAll('.btn-eliminar-linea').forEach(boton => {
        boton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            eliminarLineaPedido(id);
        });
    });
}

//========ELIMINAR LINEA DE PEDIDO========
function eliminarLineaPedido(id) {
    if (!confirm('¿Estás seguro de eliminar esta línea de pedido?')) {
        return;
    }
    
    fetch('api/lineas_pedido.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'Exito') {
            alert(data.mensaje);
            cargarLineasPedido();
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar línea de pedido');
    });
}

//========CONFIGURAR BOTONES DE NUEVA LINEA========
function configurarBotonesNuevaLinea() {
    const btnNuevaLinea = document.getElementById('btn-nueva-linea');
    if (btnNuevaLinea) {
        btnNuevaLinea.addEventListener('click', function() {
            abrirModalNuevaLinea();
        });
    }
    
    const btnGuardar = document.getElementById('btn-guardar-linea');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', guardarLineaPedido);
    }
}

//========ABRIR MODAL PARA NUEVA LINEA========
function abrirModalNuevaLinea() {
    const form = document.getElementById('formLineaPedido');
    if (form) {
        form.reset();
    }
    document.getElementById('linea-id').value = '';
    
    document.getElementById('modalLineaTitulo').textContent = 'Nueva Línea de Pedido';
    
    const modal = new bootstrap.Modal(document.getElementById('modalLineaPedido'));
    modal.show();
}

//========ABRIR MODAL PARA EDITAR LINEA========
function abrirModalEditarLinea(id) {
    fetch('api/lineas_pedido.php?id=' + id)
        .then(response => response.json())
        .then(data => {
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
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar línea de pedido');
        });
}

//========GUARDAR LINEA (CREAR O ACTUALIZAR)========
function guardarLineaPedido() {
    const id = document.getElementById('linea-id').value;
    const id_pedido = document.getElementById('linea-pedido').value;
    const id_producto = document.getElementById('linea-producto').value;
    const precio_unidad = document.getElementById('linea-precio').value;
    const cantidad = document.getElementById('linea-cantidad').value;
    const id_oferta = document.getElementById('linea-oferta').value;
    
    // Validar campos requeridos
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
    
    fetch('api/lineas_pedido.php', {
        method: metodo,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'Exito') {
            alert(data.mensaje);
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalLineaPedido'));
            modal.hide();
            
            cargarLineasPedido();
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar línea de pedido');
    });
}

//========INICIALIZACIÓN DE LINEAS PEDIDO========
function initLineasPedido() {
    configurarBotonesNuevaLinea();
    // No cargamos automáticamente, se carga cuando se navega a la sección
}
