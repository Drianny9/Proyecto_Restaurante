//====CARGAR CARRITO AL ENTRAR====
//Función para obtener el carrito y ver si el usuario ya tenia cosas guardadas
function obtenerCarrito() {
    //Pedimos datos al navegador
    const carrito = localStorage.getItem('carrito');

    //Comprobar que existe
    if (carrito) {
        //Si existe lo convertimos en un objeto/array
        return JSON.parse(carrito);
    } else {
        //No existe, devolvemos array vacio para empezar
        return [];
    }
}

//Guardar carrito en localStorage
function guardarCarrito(carrito) {
    //convertir el array a texto JSON y lo guardamos
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContadorCarrito();
}

// Verificar ofertas para productos
async function verificarOfertas(carrito) {
    const carritoConOfertas = [];
    
    for (const item of carrito) {
        try {
            const response = await fetch(`api/ofertas.php?producto=${item.id_producto}`);
            const resultado = await response.json();
            
            const itemConOferta = { ...item };
            
            // La API devuelve {estado, data} - data puede ser null si no hay oferta
            if (resultado.estado === 'Exito' && resultado.data) {
                const oferta = resultado.data;
                // Calcular precio con oferta
                let precioFinal = item.precio;
                
                // Prioridad 1: Precio especial
                if (oferta.precio_especial && oferta.precio_especial > 0) {
                    precioFinal = parseFloat(oferta.precio_especial);
                    itemConOferta.oferta = {
                        tipo: 'precio_especial',
                        precio_original: item.precio,
                        precio_oferta: precioFinal,
                        nombre: oferta.nombre,
                        id_oferta: oferta.id_oferta
                    };
                }
                // Prioridad 2: Descuento porcentual
                else if (oferta.descuento_porcentaje && oferta.descuento_porcentaje > 0) {
                    const descuento = oferta.descuento_porcentaje / 100;
                    precioFinal = item.precio * (1 - descuento);
                    itemConOferta.oferta = {
                        tipo: 'descuento_porcentaje',
                        precio_original: item.precio,
                        precio_oferta: precioFinal,
                        porcentaje: oferta.descuento_porcentaje,
                        nombre: oferta.nombre,
                        id_oferta: oferta.id_oferta
                    };
                }
                // Prioridad 3: Oferta por cantidad (2x1, etc.)
                else if (oferta.cantidad && oferta.cantidad > 1) {
                    itemConOferta.oferta = {
                        tipo: 'cantidad',
                        cantidad_requerida: parseInt(oferta.cantidad),
                        nombre: oferta.nombre,
                        id_oferta: oferta.id_oferta
                    };
                }
                
                itemConOferta.precio_con_oferta = precioFinal;
            }
            
            carritoConOfertas.push(itemConOferta);
        } catch (error) {
            console.error('Error al verificar ofertas:', error);
            carritoConOfertas.push(item);
        }
    }
    
    return carritoConOfertas;
}

//Añadir productos al carrito
function añadirAlCarrito(id_producto, nombre, precio, imagen, cantidad = 1) {
    const carrito = obtenerCarrito();

    //Creamos el nuevo objeto
    const nuevoProducto = {
        id_producto : id_producto,
        nombre : nombre,
        precio : parseFloat(precio),
        imagen : imagen,
        cantidad : cantidad
    };

    //Buscar si el producto ya está en el carrito
    const existe = carrito.find(producto => producto.id_producto === id_producto);
    if (existe) {
        //Si existe aumentamos la cantidad
        existe.cantidad += cantidad;
    } else {
        //Si no existe, lo añadimos
        //.push() para añadir elementos al final del array
        carrito.push(nuevoProducto);
    }

    guardarCarrito(carrito);
    mostrarNotificacion('Producto añadido al carrito');
}

//Eliminar producto del carrito
function eliminarDelCarrito(){
    let carrito = obtenerCarrito(); //Usamos let porque cambiaremos la variable
    carrito = carrito.filter(producto => producto.id_producto !== id_producto); //Con .filter creamos una nueva lista donde el elemento con el id que digamos desaparece
    guardarCarrito(carrito);
}

//Actualizar cantidad de un producto
function actualizarCantidad(id_producto, nuevaCantidad){
    const carrito = obtenerCarrito();
    const indice = carrito.find(producto => producto.id_producto === id_producto);

    if (indice) {
        if(nuevaCantidad <= 0){
            //Si la cantidad es menor o igual a 0 eliminamos del carrito ese producto
            carrito.splice(indice, 1); //.splice borra el elemento que le digamos.  splice(posición, cantidad_a_borrar)
        } else {
            indice.cantidad = nuevaCantidad;
        }
    }
}

//Vaciar carrito
function vaciarCarrito(){
    localStorage.removeItem('carrito');
}



//Calcular total de precio
function calcularTotal(){
    const carrito = obtenerCarrito();
    return carrito.reduce((total, producto) => total + (producto.precio * producto.cantidad), 0);
}

//Calcular total de productos que hay
function contarProductos() {
    const carrito = obtenerCarrito();
    return carrito.reduce((total, producto) => total + producto.cantidad, 0);
}

//Actualizar el contador del carrito en el navbar
function actualizarContadorCarrito() {
    const contador = document.getElementById('contador-carrito');
    if (contador) {
        const total = contarProductos();
        contador.textContent = total;
        contador.style.display = total > 0 ? 'inline-block' : 'none';
    }
}

//Mostrar notificación
function mostrarNotificacion(mensaje) {
    const notificacion = document.createElement('div');
    notificacion.className = 'notificacion-carrito';
    notificacion.textContent = mensaje;
    document.body.appendChild(notificacion);
    
    setTimeout(() => {
        notificacion.remove();
    }, 2000);
}

// ============ RENDERIZAR CARRITO EN LA PÁGINA ============

async function renderizarCarrito() {
    const carrito = obtenerCarrito();
    const contenedor = document.getElementById('lista-productos-carrito');
    const subtotalElement = document.getElementById('subtotal-carrito');
    const ivaElement = document.getElementById('iva-carrito');
    const totalElement = document.getElementById('total-carrito');
    const descuentoElement = document.getElementById('descuento-carrito');
    
    if (!contenedor) return;
    
    // Obtener templates
    const templateVacio = document.getElementById('template-carrito-vacio');
    const templateProducto = document.getElementById('template-producto-carrito');
    
    if (carrito.length === 0) {
        // Usar template de carrito vacío
        contenedor.innerHTML = '';
        if (templateVacio) {
            contenedor.appendChild(templateVacio.content.cloneNode(true));
        }
        if (subtotalElement) subtotalElement.textContent = '0,00 €';
        if (ivaElement) ivaElement.textContent = '0,00 €';
        if (totalElement) totalElement.textContent = '0,00 €';
        if (descuentoElement) {
            descuentoElement.parentElement.style.display = 'none';
        }
        return;
    }
    
    // Verificar ofertas
    const carritoConOfertas = await verificarOfertas(carrito);
    
    contenedor.innerHTML = '';
    let subtotalOriginal = 0;
    let subtotalConDescuento = 0;
    
    carritoConOfertas.forEach(item => {
        const itemId = item.id_producto || item.id;
        const precioOriginal = item.precio;
        const precioFinal = item.precio_con_oferta || item.precio;
        const subtotal = precioFinal * item.cantidad;
        const subtotalSinDescuento = precioOriginal * item.cantidad;
        
        subtotalOriginal += subtotalSinDescuento;
        subtotalConDescuento += subtotal;
        
        // Clonar template
        const clone = templateProducto.content.cloneNode(true);
        const card = clone.querySelector('.producto-card');
        
        // Rellenar datos básicos
        card.dataset.id = itemId;
        clone.querySelector('.producto-imagen').src = `assets/images/carta/${item.imagen}`;
        clone.querySelector('.producto-imagen').alt = item.nombre;
        clone.querySelector('.cantidad-valor').textContent = item.cantidad;
        clone.querySelector('.producto-subtotal').textContent = `${subtotal.toFixed(2)} €`;
        
        // Nombre con badge de oferta
        const nombreElement = clone.querySelector('.producto-nombre');
        nombreElement.textContent = item.nombre;
        if (item.oferta) {
            const badge = document.createElement('span');
            badge.className = 'badge ms-2';
            if (item.oferta.tipo === 'precio_especial') {
                badge.classList.add('bg-danger');
                badge.textContent = 'Precio Especial';
            } else if (item.oferta.tipo === 'descuento_porcentaje') {
                badge.classList.add('bg-warning', 'text-dark');
                badge.textContent = `-${item.oferta.porcentaje}%`;
            } else if (item.oferta.tipo === 'cantidad') {
                badge.classList.add('bg-info', 'text-dark');
                badge.textContent = `${item.oferta.cantidad_requerida}x${item.oferta.cantidad_requerida}`;
            }
            nombreElement.appendChild(badge);
        }
        
        // Precio (con tachado si hay oferta)
        const precioElement = clone.querySelector('.producto-precio');
        if (item.oferta && (item.oferta.tipo === 'precio_especial' || item.oferta.tipo === 'descuento_porcentaje')) {
            precioElement.innerHTML = `
                <span class="text-decoration-line-through text-muted">${precioOriginal.toFixed(2)} €</span>
                <span class="text-danger fw-bold ms-2">${precioFinal.toFixed(2)} €</span> / unidad
            `;
        } else {
            precioElement.textContent = `${precioFinal.toFixed(2)} € / unidad`;
        }
        
        // Configurar botones con eventos (sin onclick inline)
        clone.querySelector('.btn-restar').addEventListener('click', () => cambiarCantidad(itemId, -1));
        clone.querySelector('.btn-sumar').addEventListener('click', () => cambiarCantidad(itemId, 1));
        clone.querySelector('.btn-eliminar-producto').addEventListener('click', () => eliminarProducto(itemId));
        
        contenedor.appendChild(clone);
    });
    
    // Calcular totales
    const descuentoTotal = subtotalOriginal - subtotalConDescuento;
    const iva = subtotalConDescuento * 0.10;
    const total = subtotalConDescuento + iva;
    
    // Mostrar descuento solo si existe
    const descuentoRow = document.getElementById('descuento-row');
    if (descuentoRow) {
        if (descuentoTotal > 0) {
            descuentoElement.textContent = '-' + descuentoTotal.toFixed(2).replace('.', ',') + ' €';
            descuentoRow.style.display = 'flex';
        } else {
            descuentoRow.style.display = 'none';
        }
    }
    
    if (subtotalElement) subtotalElement.textContent = subtotalConDescuento.toFixed(2).replace('.', ',') + ' €';
    if (ivaElement) ivaElement.textContent = iva.toFixed(2).replace('.', ',') + ' €';
    if (totalElement) totalElement.textContent = total.toFixed(2).replace('.', ',') + ' €';
}

// Cambiar cantidad de un producto
function cambiarCantidad(id_producto, cambio) {
    const carrito = obtenerCarrito();
    // Buscar por id_producto o id (compatibilidad)
    const item = carrito.find(p => (p.id_producto == id_producto) || (p.id == id_producto));
    
    if (item) {
        const nuevaCantidad = item.cantidad + cambio;
        if (nuevaCantidad > 0) {
            item.cantidad = nuevaCantidad;
            guardarCarritoSinAlerta(carrito);
        } else {
            eliminarProducto(id_producto);
            return;
        }
        renderizarCarrito();
    }
}

// Guardar sin mostrar alerta (para actualizar cantidades)
function guardarCarritoSinAlerta(carrito) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
    actualizarContadorCarrito();
}

// Eliminar producto con confirmación
function eliminarProducto(id_producto) {
    if (confirm('¿Eliminar este producto del carrito?')) {
        let carrito = obtenerCarrito();
        // Filtrar por id_producto o id (compatibilidad)
        carrito = carrito.filter(p => (p.id_producto != id_producto) && (p.id != id_producto));
        guardarCarritoSinAlerta(carrito);
        renderizarCarrito();
    }
}

// Vaciar carrito con confirmación
function confirmarVaciar() {
    if (confirm('¿Vaciar todo el carrito?')) {
        localStorage.removeItem('carrito');
        actualizarContadorCarrito();
        renderizarCarrito();
    }
}

// ============ FINALIZAR PEDIDO ============

function tramitarPedido() {
    const carrito = obtenerCarrito();
    
    if (carrito.length === 0) {
        alert('El carrito está vacío');
        return;
    }
    
    // Redirigir a checkout
    window.location.href = '?controller=Carrito&action=checkout';
}

function finalizarPedido() {
    const carrito = obtenerCarrito();
    
    if (carrito.length === 0) {
        alert('El carrito está vacío');
        return;
    }
    
    fetch('api/carrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            accion: 'procesar',
            productos: carrito,
            total: calcularTotal()
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'Exito') {
            localStorage.removeItem('carrito');
            actualizarContadorCarrito();
            window.location.href = '?controller=Carrito&action=confirmacion&id=' + data.data.id_pedido;
        } else {
            alert('Error: ' + data.mensaje);
            if (data.requiere_login) {
                window.location.href = '?controller=Log&action=login';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar el pedido');
    });
}

// ============ INICIALIZACIÓN ============

document.addEventListener('DOMContentLoaded', function() {
    actualizarContadorCarrito();
    
    if (document.getElementById('lista-productos-carrito')) {
        renderizarCarrito();
    }
});