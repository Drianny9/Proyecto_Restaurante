//====PRODUCTOS - Gestión CRUD====

//========CARGAR PRODUCTOS========
function cargarProductos() {
    fetch('api/productos.php')
        .then(response => response.json()).then(data => {
            if (data.estado === 'Exito') {
                mostrarProductos(data.data);
            }else {
                console.error('Error al cargar productos', data.mensaje);
            }
        })
        .catch(error => {
            console.error('Error en la petición:', error);
        });
} 

//========MOSTRAR PRODUCTOS EN LA TABLA========
function mostrarProductos(productos) {
    const tbody = document.getElementById('tabla-productos');
    tbody.innerHTML = '';
    
    if (productos.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay productos</td></tr>';
        return;
    }
    
    productos.forEach(producto => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td>${producto.id_producto}</td>
            <td>${producto.nombre}</td>
            <td>${producto.descripcion}</td>
            <td>${Number(producto.precio_base).toFixed(2)} €</td>
            <td>${producto.imagen || '-'}</td>
            <td>
                <button class="btn btn-sm btn-warning btn-editar-producto" data-id="${producto.id_producto}">
                    Editar
                </button>
                <button class="btn btn-sm btn-danger btn-eliminar-producto" data-id="${producto.id_producto}">
                    Eliminar
                </button>
            </td>
        `;
        tbody.appendChild(fila);
    });
    
    configurarBotonesProductos();
}

//========CONFIGURAR BOTONES DE PRODUCTOS========
function configurarBotonesProductos() {
    document.querySelectorAll('.btn-editar-producto').forEach(boton => {
        boton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            abrirModalEditarProducto(id);
        });
    });
    
    document.querySelectorAll('.btn-eliminar-producto').forEach(boton => {
        boton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            eliminarProducto(id);
        });
    });
}

//========ELIMINAR PRODUCTO========
function eliminarProducto(id) {
    //Preguntamos si se esta seguro de eliminar
    if (!confirm('¿Estas seguro de eliminar este producto?')) {
        //Si cancela no hace nada
        return;
    }
    
    //LLamamos al metodo DELETE de la API con una petición HTTP
    fetch('api/productos.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }, //Indicamos que se envia JSON
        body: JSON.stringify({ id: id }) /*enviamos el ID del producto. 
                                          stringify convierte el JSON en string para que PHP lo pueda leer*/
    })
    .then(response => response.json()) //Convertir respuesta a JSON
    .then(data => {
        if (data.estado === 'Exito') {
            alert(data.mensaje);
            cargarProductos(); //Actualizamos la tabla productos
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar producto');
    });
}

//========CONFIGURAR BOTONES DE NUEVO PRODUCTO========
function configurarBotonesNuevoProducto() {
    const btnNuevoProducto = document.getElementById('btn-nuevo-producto');
    if (btnNuevoProducto) {
        btnNuevoProducto.addEventListener('click', function() {
            abrirModalNuevoProducto();
        });
    }
    
    // Configurar boton guardar del modal
    const btnGuardar = document.getElementById('btn-guardar-producto');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', guardarProducto);
    }
}

//========ABRIR MODAL PARA NUEVO PRODUCTO========
function abrirModalNuevoProducto() {
    // Limpiar formulario
    document.getElementById('formProducto').reset();
    document.getElementById('producto-id').value = '';
    
    // Cambiar titulo
    document.getElementById('modalProductoTitulo').textContent = 'Nuevo Producto';
    
    // Abrir modal
    const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
    modal.show();
}

//========ABRIR MODAL PARA EDITAR PRODUCTO========
function abrirModalEditarProducto(id) {
    // Obtener datos del producto
    fetch('api/productos.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                const producto = data.data;
                
                // Rellenar formulario
                document.getElementById('producto-id').value = producto.id_producto;
                document.getElementById('producto-nombre').value = producto.nombre;
                document.getElementById('producto-descripcion').value = producto.descripcion || '';
                document.getElementById('producto-categoria').value = producto.id_categoria;
                document.getElementById('producto-precio').value = producto.precio_base;
                document.getElementById('producto-imagen').value = producto.imagen || '';
                
                // Cambiar titulo
                document.getElementById('modalProductoTitulo').textContent = 'Editar Producto';
                
                // Abrir modal
                const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
                modal.show();
            } else {
                alert('Error al cargar producto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cargar producto');
        });
}

//========GUARDAR PRODUCTO (CREAR O ACTUALIZAR)========
function guardarProducto() {
    const id = document.getElementById('producto-id').value;
    const nombre = document.getElementById('producto-nombre').value;
    const descripcion = document.getElementById('producto-descripcion').value;
    const id_categoria = document.getElementById('producto-categoria').value;
    const precio_base = document.getElementById('producto-precio').value;
    const imagen = document.getElementById('producto-imagen').value;
    
    // Validar campos requeridos
    if (!nombre || !id_categoria || !precio_base) {
        alert('Por favor, rellena todos los campos obligatorios');
        return;
    }
    
    const datos = {
        nombre: nombre,
        descripcion: descripcion,
        id_categoria: parseInt(id_categoria),
        precio_base: parseFloat(precio_base),
        imagen: imagen
    };
    
    let metodo = 'POST';
    if (id) {
        // Si hay ID, es una actualización
        metodo = 'PUT';
        datos.id = parseInt(id);
    }
    
    fetch('api/productos.php', {
        method: metodo,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'Exito') {
            alert(data.mensaje);
            
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalProducto'));
            modal.hide();
            
            // Recargar tabla
            cargarProductos();
        } else {
            alert('Error: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar producto');
    });
}

//========INICIALIZACIÓN DE PRODUCTOS========
function initProductos() {
    cargarProductos();
    configurarBotonesNuevoProducto();
}
