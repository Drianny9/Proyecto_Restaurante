/*
 * Script para filtrar productos por categoria
 * Funciona con los checkboxes del panel de filtros
 */

document.addEventListener('DOMContentLoaded', function() {
    // Seleccionamos todos los checkboxes de filtro y las tarjetas de producto
    const filtros = document.querySelectorAll('.filtro-checkbox');
    const productos = document.querySelectorAll('.producto-card');

    // Cada vez que se cambia un filtro, actualizamos los productos visibles
    filtros.forEach(filtro => {
        filtro.addEventListener('change', function() {
            // Obtenemos las categorias seleccionadas
            const categoriasActivas = [];
            filtros.forEach(f => {
                if (f.checked) {
                    categoriasActivas.push(f.dataset.categoria);
                }
            });

            // Si no hay filtros activos, mostramos todos los productos
            if (categoriasActivas.length === 0) {
                productos.forEach(p => p.style.display = 'block');
            } else {
                // Si hay filtros, mostramos solo los productos de esas categorias
                productos.forEach(p => {
                    if (categoriasActivas.includes(p.dataset.categoria)) {
                        p.style.display = 'block';
                    } else {
                        p.style.display = 'none';
                    }
                });
            }
        });
    });
});
