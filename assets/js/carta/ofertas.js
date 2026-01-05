// Script para mostrar ofertas activas en la carta de productos

async function cargarOfertasEnCarta() {
    const tarjetasProductos = document.querySelectorAll('.producto-card[data-producto-id]');
    
    // Obtener templates
    const templateBadgeOferta = document.getElementById('template-badge-oferta');
    const templateBadgeDescuento = document.getElementById('template-badge-descuento');
    const templateBadgeCantidad = document.getElementById('template-badge-cantidad');
    
    for (const tarjeta of tarjetasProductos) {
        const idProducto = tarjeta.dataset.productoId;
        const precioBase = parseFloat(tarjeta.dataset.precioBase);
        
        try {
            const response = await fetch(`api/ofertas.php?producto=${idProducto}`);
            const resultado = await response.json();
            
            // La API devuelve {estado, data} - data puede ser null si no hay oferta
            if (resultado.estado === 'Exito' && resultado.data) {
                const oferta = resultado.data;
                const precioElemento = tarjeta.querySelector('[data-precio-elemento]');
                const imagenContainer = tarjeta.querySelector('.producto-imagen-container');
                
                let precioFinal = precioBase;
                let badge = null;
                
                // Prioridad 1: Precio especial
                if (oferta.precio_especial && oferta.precio_especial > 0) {
                    precioFinal = parseFloat(oferta.precio_especial);
                    
                    // Clonar template de badge
                    if (templateBadgeOferta) {
                        badge = templateBadgeOferta.content.cloneNode(true);
                    }
                    
                    // Actualizar precio con template inline (es mínimo HTML)
                    if (precioElemento) {
                        actualizarPrecioConOferta(precioElemento, precioBase, precioFinal);
                    }
                }
                // Prioridad 2: Descuento porcentual
                else if (oferta.descuento_porcentaje && oferta.descuento_porcentaje > 0) {
                    const descuento = oferta.descuento_porcentaje / 100;
                    precioFinal = precioBase * (1 - descuento);
                    
                    // Clonar template de badge con porcentaje
                    if (templateBadgeDescuento) {
                        badge = templateBadgeDescuento.content.cloneNode(true);
                        badge.querySelector('.badge').textContent = `-${oferta.descuento_porcentaje}%`;
                    }
                    
                    if (precioElemento) {
                        actualizarPrecioConOferta(precioElemento, precioBase, precioFinal);
                    }
                }
                // Prioridad 3: Oferta por cantidad
                else if (oferta.cantidad && oferta.cantidad > 1) {
                    if (templateBadgeCantidad) {
                        badge = templateBadgeCantidad.content.cloneNode(true);
                        badge.querySelector('.badge').textContent = `${oferta.cantidad}x${oferta.cantidad}`;
                    }
                }
                
                // Agregar badge si existe y no hay uno ya
                if (badge && imagenContainer && !imagenContainer.querySelector('.badge')) {
                    imagenContainer.appendChild(badge);
                }
                
                // Guardar datos de oferta en el elemento
                tarjeta.dataset.precioConOferta = precioFinal;
                if (oferta.id_oferta) {
                    tarjeta.dataset.idOferta = oferta.id_oferta;
                }
            }
        } catch (error) {
            console.error(`Error al cargar oferta para producto ${idProducto}:`, error);
        }
    }
}

// Función auxiliar para actualizar precio con estilo de oferta
function actualizarPrecioConOferta(elemento, precioOriginal, precioOferta) {
    const label = elemento.querySelector('.precio-label');
    const valor = elemento.querySelector('.precio-valor');
    
    if (valor) {
        valor.innerHTML = '';
        
        // Precio original tachado
        const precioTachado = document.createElement('span');
        precioTachado.className = 'text-decoration-line-through text-muted';
        precioTachado.style.fontSize = '14px';
        precioTachado.textContent = `${precioOriginal.toFixed(2)} €`;
        
        // Precio con descuento
        const precioNuevo = document.createElement('span');
        precioNuevo.className = 'text-danger fw-bold ms-2';
        precioNuevo.textContent = `${precioOferta.toFixed(2)} €`;
        
        valor.appendChild(precioTachado);
        valor.appendChild(precioNuevo);
    }
}

// Ejecutar cuando la página cargue
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', cargarOfertasEnCarta);
} else {
    cargarOfertasEnCarta();
}
