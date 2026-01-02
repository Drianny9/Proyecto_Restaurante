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
    alert("Producto añadido!");
    actualizarContadorCarrito();
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

function renderizarCarrito() {
    const carrito = obtenerCarrito();
    const contenedor = document.getElementById('contenido-carrito');
    const totalElement = document.getElementById('total-carrito');
    
    if (!contenedor) return;
    
    if (carrito.length === 0) {
        contenedor.innerHTML = `
            <div class="carrito-vacio">
                <p>Tu carrito está vacío</p>
                <a href="?controller=Producto&action=verCarta" class="btn-ir-carta">Ver Carta</a>
            </div>
        `;
        if (totalElement) totalElement.textContent = '0.00 €';
        return;
    }
    
    let html = `
        <table class="carrito-tabla">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        html += `
            <tr data-id="${item.id_producto}">
                <td class="producto-info">
                    <img src="assets/images/productos/${item.imagen}" alt="${item.nombre}" class="carrito-imagen">
                    <span>${item.nombre}</span>
                </td>
                <td>${item.precio.toFixed(2)} €</td>
                <td>
                    <div class="control-cantidad">
                        <button class="btn-cantidad" onclick="cambiarCantidad(${item.id_producto}, -1)">-</button>
                        <span class="cantidad-valor">${item.cantidad}</span>
                        <button class="btn-cantidad" onclick="cambiarCantidad(${item.id_producto}, 1)">+</button>
                    </div>
                </td>
                <td class="subtotal">${subtotal.toFixed(2)} €</td>
                <td>
                    <button class="btn-eliminar" onclick="eliminarProducto(${item.id_producto})">
                        Eliminar
                    </button>
                </td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
        <div class="carrito-acciones">
            <button class="btn-vaciar" onclick="confirmarVaciar()">Vaciar Carrito</button>
            <a href="?controller=Producto&action=verCarta" class="btn-seguir">Seguir Comprando</a>
            <button class="btn-procesar" onclick="finalizarPedido()">Finalizar Pedido</button>
        </div>
    `;
    
    contenedor.innerHTML = html;
    
    if (totalElement) {
        totalElement.textContent = calcularTotal().toFixed(2) + ' €';
    }
}

// Cambiar cantidad de un producto
function cambiarCantidad(id_producto, cambio) {
    const carrito = obtenerCarrito();
    const item = carrito.find(p => p.id_producto === id_producto);
    
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
        carrito = carrito.filter(p => p.id_producto !== id_producto);
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
    
    if (document.getElementById('contenido-carrito')) {
        renderizarCarrito();
    }
});