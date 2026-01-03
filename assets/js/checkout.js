// ============ CHECKOUT - PÁGINA DE PAGO ============

document.addEventListener('DOMContentLoaded', function() {
    // Solo ejecutar si estamos en la página de checkout
    if (document.getElementById('checkout-productos')) {
        renderizarCheckout();
        
        // Manejar envío del formulario
        const formCheckout = document.getElementById('form-checkout');
        if (formCheckout) {
            formCheckout.addEventListener('submit', function(e) {
                e.preventDefault();
                procesarPago();
            });
        }
    }
});

// Renderizar productos en checkout
function renderizarCheckout() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const contenedor = document.getElementById('checkout-productos');
    const subtotalElement = document.getElementById('checkout-subtotal');
    const ivaElement = document.getElementById('checkout-iva');
    const totalElement = document.getElementById('checkout-total');
    
    if (!contenedor) return;
    
    // Si carrito vacío, redirigir
    if (carrito.length === 0) {
        window.location.href = '?controller=Carrito&action=verCarrito';
        return;
    }
    
    let html = '';
    let subtotalCalc = 0;
    
    carrito.forEach(item => {
        const precio = item.precio * item.cantidad;
        subtotalCalc += precio;
        html += `
            <div class="checkout-producto d-flex align-items-center gap-3 mb-3">
                <img src="assets/images/carta/${item.imagen}" alt="${item.nombre}" class="checkout-producto-img">
                <div class="flex-grow-1">
                    <span class="text-white">${item.nombre}</span>
                    ${item.cantidad > 1 ? `<span class="text-white-50 small"> x${item.cantidad}</span>` : ''}
                </div>
                <span class="text-white fw-bold">${precio.toFixed(2).replace('.', ',')} €</span>
            </div>
        `;
    });
    
    contenedor.innerHTML = html;
    
    // Calcular totales
    const iva = subtotalCalc * 0.10;
    const total = subtotalCalc + iva;
    
    if (subtotalElement) subtotalElement.textContent = subtotalCalc.toFixed(2).replace('.', ',') + ' €';
    if (ivaElement) ivaElement.textContent = iva.toFixed(2).replace('.', ',') + ' €';
    if (totalElement) totalElement.textContent = total.toFixed(2).replace('.', ',') + ' €';
}

// Procesar el pago
function procesarPago() {
    const nombre = document.getElementById('nombre-completo').value;
    const correo = document.getElementById('correo').value;
    const direccion = document.getElementById('direccion').value;
    const metodoPago = document.querySelector('input[name="metodo-pago"]:checked')?.value;
    
    if (!nombre || !correo || !direccion) {
        alert('Por favor, completa todos los campos');
        return;
    }
    
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    
    if (carrito.length === 0) {
        alert('El carrito está vacío');
        return;
    }
    
    // Calcular total
    let subtotal = 0;
    carrito.forEach(item => {
        subtotal += item.precio * item.cantidad;
    });
    const total = subtotal * 1.10; // Con IVA
    
    // Enviar pedido al servidor
    fetch('api/carrito.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            accion: 'procesar',
            productos: carrito,
            total: total,
            datos_cliente: {
                nombre: nombre,
                correo: correo,
                direccion: direccion,
                metodo_pago: metodoPago
            }
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.estado === 'Exito') {
            // Limpiar carrito
            localStorage.removeItem('carrito');
            actualizarContadorCarrito();
            // Redirigir a confirmación
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
