//====CLASE CARRITO====
//Gestiona el carrito de compras con localStorage

class Carrito {
    constructor(storageKey = 'carrito') {
        this.storageKey = storageKey;
    }

    //Obtener carrito del localStorage
    obtener() {
        //Pedimos datos al navegador
        const carrito = localStorage.getItem(this.storageKey);
        //Si existe lo convertimos en un objeto/array, si no devolvemos array vacio
        return carrito ? JSON.parse(carrito) : [];
    }

    //Guardar carrito en localStorage y actualizar contador
    guardar(carrito) {
        //Convertir el array a texto JSON y lo guardamos
        localStorage.setItem(this.storageKey, JSON.stringify(carrito));
        this.actualizarContador();
    }

    //Guardar sin mostrar alerta (para actualizar cantidades)
    guardarSinAlerta(carrito) {
        localStorage.setItem(this.storageKey, JSON.stringify(carrito));
        this.actualizarContador();
    }

    //Verificar ofertas para productos del carrito - usa Promise.all + map
    async verificarOfertas(carrito) {
        //Promise.all + map para paralelizar todas las peticiones a la vez
        const carritoConOfertas = await Promise.all(
            carrito.map(async (producto) => {
                try {
                    const response = await fetch(`api/ofertas.php?producto=${producto.id_producto}`);
                    const resultado = await response.json();

                    //Spread operator (...) para clonar sin mutar el original
                    const prodConOferta = { ...producto };

                    //La API devuelve {estado, data} - data puede ser null si no hay oferta
                    if (resultado.estado === 'Exito' && resultado.data) {
                        const oferta = resultado.data;
                        //Calcular precio con oferta
                        let precioFinal = producto.precio;

                        //Prioridad 1: Precio especial
                        if (oferta.precio_especial && oferta.precio_especial > 0) {
                            precioFinal = parseFloat(oferta.precio_especial);
                            prodConOferta.oferta = {
                                tipo: 'precio_especial',
                                precio_original: producto.precio,
                                precio_oferta: precioFinal,
                                nombre: oferta.nombre,
                                id_oferta: oferta.id_oferta
                            };
                        }
                        //Prioridad 2: Descuento porcentual
                        else if (oferta.descuento_porcentaje && oferta.descuento_porcentaje > 0) {
                            const descuento = oferta.descuento_porcentaje / 100;
                            precioFinal = producto.precio * (1 - descuento);
                            prodConOferta.oferta = {
                                tipo: 'descuento_porcentaje',
                                precio_original: producto.precio,
                                precio_oferta: precioFinal,
                                porcentaje: oferta.descuento_porcentaje,
                                nombre: oferta.nombre,
                                id_oferta: oferta.id_oferta
                            };
                        }
                        //Prioridad 3: Oferta por cantidad (2x1, etc.)
                        else if (oferta.cantidad && oferta.cantidad > 1) {
                            prodConOferta.oferta = {
                                tipo: 'cantidad',
                                cantidad_requerida: parseInt(oferta.cantidad),
                                nombre: oferta.nombre,
                                id_oferta: oferta.id_oferta
                            };
                        }

                        prodConOferta.precio_con_oferta = precioFinal;
                    }

                    return prodConOferta;
                } catch (error) {
                    console.error('Error al verificar ofertas:', error);
                    return producto;
                }
            })
        );

        return carritoConOfertas;
    }

    //Añadir productos al carrito - usa find
    añadir(id_producto, nombre, precio, imagen, cantidad = 1) {
        const carrito = this.obtener();

        //Creamos el nuevo objeto
        const nuevoProducto = {
            id_producto: id_producto,
            nombre: nombre,
            precio: parseFloat(precio),
            imagen: imagen,
            cantidad: cantidad
        };

        //Buscar si el producto ya está en el carrito con find
        const existe = carrito.find(producto => producto.id_producto === id_producto);
        if (existe) {
            //Si existe aumentamos la cantidad
            existe.cantidad += cantidad;
        } else {
            //Si no existe, lo añadimos
            //.push() para añadir elementos al final del array
            carrito.push(nuevoProducto);
        }

        this.guardar(carrito);
        this.mostrarNotificacion('Producto añadido al carrito');
    }

    //Eliminar producto del carrito - usa filter
    eliminar(id_producto) {
        let carrito = this.obtener(); //Usamos let porque cambiaremos la variable
        //Con .filter creamos una nueva lista donde el elemento con el id que digamos desaparece
        carrito = carrito.filter(p => (p.id_producto != id_producto) && (p.id != id_producto));
        this.guardarSinAlerta(carrito);
    }

    //Actualizar cantidad de un producto - usa find
    actualizarCantidad(id_producto, nuevaCantidad) {
        const carrito = this.obtener();
        const item = carrito.find(producto => producto.id_producto === id_producto);

        if (item) {
            if (nuevaCantidad <= 0) {
                //Si la cantidad es menor o igual a 0 eliminamos del carrito ese producto
                const indice = carrito.indexOf(item);
                carrito.splice(indice, 1); //.splice borra el elemento que le digamos
            } else {
                item.cantidad = nuevaCantidad;
            }
            this.guardarSinAlerta(carrito);
        }
    }

    //Cambiar cantidad de un producto (sumar o restar) - usa find
    cambiarCantidad(id_producto, cambio) {
        const carrito = this.obtener();
        //Buscar por id_producto o id (compatibilidad)
        const item = carrito.find(p => (p.id_producto == id_producto) || (p.id == id_producto));

        if (item) {
            const nuevaCantidad = item.cantidad + cambio;
            if (nuevaCantidad > 0) {
                item.cantidad = nuevaCantidad;
                this.guardarSinAlerta(carrito);
            } else {
                this.eliminarConConfirmacion(id_producto);
                return;
            }
            this.renderizar();
        }
    }

    //Vaciar carrito completamente
    vaciar() {
        localStorage.removeItem(this.storageKey);
        this.actualizarContador();
    }

    //Calcular total de precio con ofertas aplicadas - usa reduce
    async calcularTotal() {
        const carrito = this.obtener();
        const carritoConOfertas = await this.verificarOfertas(carrito);
        //reduce recorre el array y acumula el total sumando precio * cantidad
        return carritoConOfertas.reduce((total, producto) => {
            const precioFinal = producto.precio_con_oferta || producto.precio;
            return total + (precioFinal * producto.cantidad);
        }, 0);
    }

    //Versión síncrona para calcular total sin ofertas (fallback) - usa reduce
    calcularTotalSinOfertas() {
        return this.obtener().reduce((total, producto) => {
            return total + (producto.precio * producto.cantidad);
        }, 0);
    }

    //Calcular total de productos que hay - usa reduce
    contarProductos() {
        return this.obtener().reduce((total, producto) => total + producto.cantidad, 0);
    }

    //Actualizar el contador del carrito en el navbar - usa forEach
    actualizarContador() {
        const total = this.contarProductos();
        //forEach para actualizar todos los contadores que haya en la página
        document.querySelectorAll('#contador-carrito, #contador-carrito-menu')
            .forEach(el => {
                if (el) {
                    el.textContent = total;
                    el.style.display = total > 0 ? 'inline-block' : 'none';
                }
            });
    }

    //Mostrar notificación temporal
    mostrarNotificacion(mensaje) {
        //Quitar notificación anterior si existe
        const anterior = document.querySelector('.notificacion-carrito');
        if (anterior) anterior.remove();

        const notificacion = document.createElement('div');
        notificacion.className = 'notificacion-carrito';
        notificacion.textContent = mensaje;
        document.body.appendChild(notificacion);

        setTimeout(() => {
            notificacion.remove();
        }, 2000);
    }

    // ============ RENDERIZAR CARRITO EN LA PÁGINA ============

    async renderizar() {
        const carrito = this.obtener();
        const contenedor = document.getElementById('lista-productos-carrito');
        const subtotalElement = document.getElementById('subtotal-carrito');
        const ivaElement = document.getElementById('iva-carrito');
        const totalElement = document.getElementById('total-carrito');
        const descuentoElement = document.getElementById('descuento-carrito');

        //Si no estamos en la página del carrito, salir
        if (!contenedor) return;

        //Obtener templates
        const templateVacio = document.getElementById('template-carrito-vacio');
        const templateProducto = document.getElementById('template-producto-carrito');

        if (carrito.length === 0) {
            //Usar template de carrito vacío
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

        //Verificar ofertas para todos los productos
        const carritoConOfertas = await this.verificarOfertas(carrito);

        contenedor.innerHTML = '';
        let subtotalOriginal = 0;
        let subtotalConDescuento = 0;

        //forEach para recorrer y renderizar cada producto
        carritoConOfertas.forEach(item => {
            const itemId = item.id_producto || item.id;
            const precioOriginal = item.precio;
            const precioFinal = item.precio_con_oferta || item.precio;
            const subtotal = precioFinal * item.cantidad;
            const subtotalSinDescuento = precioOriginal * item.cantidad;

            subtotalOriginal += subtotalSinDescuento;
            subtotalConDescuento += subtotal;

            //Clonar template
            const clone = templateProducto.content.cloneNode(true);
            const card = clone.querySelector('.producto-card');

            //Rellenar datos básicos
            card.dataset.id = itemId;
            clone.querySelector('.producto-imagen').src = `assets/images/carta/${item.imagen}`;
            clone.querySelector('.producto-imagen').alt = item.nombre;
            clone.querySelector('.cantidad-valor').textContent = item.cantidad;
            clone.querySelector('.producto-subtotal').textContent = `${subtotal.toFixed(2)} €`;

            //Nombre con badge de oferta
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

            //Precio (con tachado si hay oferta)
            const precioElement = clone.querySelector('.producto-precio');
            if (item.oferta && (item.oferta.tipo === 'precio_especial' || item.oferta.tipo === 'descuento_porcentaje')) {
                precioElement.innerHTML = `
                    <span class="text-decoration-line-through text-muted">${precioOriginal.toFixed(2)} €</span>
                    <span class="text-danger fw-bold ms-2">${precioFinal.toFixed(2)} €</span> / unidad
                `;
            } else {
                precioElement.textContent = `${precioFinal.toFixed(2)} € / unidad`;
            }

            //Configurar botones con eventos (sin onclick inline)
            clone.querySelector('.btn-restar').addEventListener('click', () => this.cambiarCantidad(itemId, -1));
            clone.querySelector('.btn-sumar').addEventListener('click', () => this.cambiarCantidad(itemId, 1));
            clone.querySelector('.btn-eliminar-producto').addEventListener('click', () => this.eliminarConConfirmacion(itemId));

            contenedor.appendChild(clone);
        });

        //Calcular totales
        const descuentoTotal = subtotalOriginal - subtotalConDescuento;
        const iva = subtotalConDescuento * 0.10;
        const total = subtotalConDescuento + iva;

        //Mostrar descuento solo si existe
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

    //Eliminar producto con confirmación
    eliminarConConfirmacion(id_producto) {
        if (confirm('¿Eliminar este producto del carrito?')) {
            this.eliminar(id_producto);
            this.renderizar();
        }
    }

    //Vaciar carrito con confirmación
    confirmarVaciar() {
        if (confirm('¿Vaciar todo el carrito?')) {
            this.vaciar();
            this.renderizar();
        }
    }

    //Tramitar pedido - redirige a checkout
    tramitar() {
        const carrito = this.obtener();

        if (carrito.length === 0) {
            alert('El carrito está vacío');
            return;
        }

        //Redirigir a checkout
        window.location.href = '?controller=Carrito&action=checkout';
    }

    //Finalizar pedido - envía al servidor
    async finalizar() {
        const carrito = this.obtener();

        if (carrito.length === 0) {
            alert('El carrito está vacío');
            return;
        }

        //Verificar ofertas antes de enviar
        const carritoConOfertas = await this.verificarOfertas(carrito);
        const total = await this.calcularTotal();

        fetch('api/carrito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                accion: 'procesar',
                productos: carritoConOfertas,
                total: total
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                this.vaciar();
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
}

//====INSTANCIA GLOBAL====
const miCarrito = new Carrito();

//====FUNCIONES WRAPPER GLOBALES====
//Necesarias para mantener compatibilidad con el HTML existente (onclick) y otros scripts
function obtenerCarrito() { return miCarrito.obtener(); }
function guardarCarrito(carrito) { miCarrito.guardar(carrito); }
function guardarCarritoSinAlerta(carrito) { miCarrito.guardarSinAlerta(carrito); }
async function verificarOfertas(carrito) { return miCarrito.verificarOfertas(carrito); }
function añadirAlCarrito(id_producto, nombre, precio, imagen, cantidad = 1) { miCarrito.añadir(id_producto, nombre, precio, imagen, cantidad); }
function eliminarDelCarrito(id_producto) { miCarrito.eliminar(id_producto); }
function actualizarCantidad(id_producto, nuevaCantidad) { miCarrito.actualizarCantidad(id_producto, nuevaCantidad); }
function vaciarCarrito() { miCarrito.vaciar(); }
async function calcularTotal() { return miCarrito.calcularTotal(); }
function calcularTotalSinOfertas() { return miCarrito.calcularTotalSinOfertas(); }
function contarProductos() { return miCarrito.contarProductos(); }
function actualizarContadorCarrito() { miCarrito.actualizarContador(); }
function mostrarNotificacion(mensaje) { miCarrito.mostrarNotificacion(mensaje); }
async function renderizarCarrito() { return miCarrito.renderizar(); }
function cambiarCantidad(id_producto, cambio) { miCarrito.cambiarCantidad(id_producto, cambio); }
function eliminarProducto(id_producto) { miCarrito.eliminarConConfirmacion(id_producto); }
function confirmarVaciar() { miCarrito.confirmarVaciar(); }
function tramitarPedido() { miCarrito.tramitar(); }
async function finalizarPedido() { return miCarrito.finalizar(); }

// ============ INICIALIZACIÓN ============

document.addEventListener('DOMContentLoaded', function() {
    miCarrito.actualizarContador();

    //Si estamos en la página del carrito, renderizar
    if (document.getElementById('lista-productos-carrito')) {
        miCarrito.renderizar();
    }
});