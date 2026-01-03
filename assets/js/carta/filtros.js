/*
 * Script para filtrar productos por categoria
 * y gestionar el carrito desde la página de carta
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // =====================
    // FILTRADO POR CATEGORÍA
    // =====================
    
    const filtros = document.querySelectorAll('.filtro-checkbox');
    const productos = document.querySelectorAll('.producto-card');
    const categoriaToggle = document.getElementById('categoriaToggle');
    const categoriasLista = document.getElementById('categoriasLista');
    const categoriaArrow = document.querySelector('.categoria-arrow');

    // Toggle para mostrar/ocultar categorías
    if (categoriaToggle) {
        categoriaToggle.addEventListener('click', function() {
            categoriasLista.classList.toggle('collapsed');
            categoriaArrow.classList.toggle('collapsed');
        });
    }

    // Filtrar productos cuando cambia un checkbox
    filtros.forEach(filtro => {
        filtro.addEventListener('change', function() {
            // Obtener categorías seleccionadas
            const categoriasActivas = [];
            filtros.forEach(f => {
                if (f.checked) {
                    categoriasActivas.push(f.dataset.categoria);
                }
            });

            // Si no hay filtros activos, mostrar todos
            if (categoriasActivas.length === 0) {
                productos.forEach(p => {
                    p.style.display = 'flex';
                    p.style.animation = 'fadeIn 0.3s ease';
                });
            } else {
                // Mostrar solo los de las categorías seleccionadas
                productos.forEach(p => {
                    if (categoriasActivas.includes(p.dataset.categoria)) {
                        p.style.display = 'flex';
                        p.style.animation = 'fadeIn 0.3s ease';
                    } else {
                        p.style.display = 'none';
                    }
                });
            }
        });
    });

    // =====================
    // FAVORITOS
    // =====================
    
    const btnsFavorito = document.querySelectorAll('.btn-favorito');
    
    btnsFavorito.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                this.classList.add('active');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                this.classList.remove('active');
            }
        });
    });

    // =====================
    // AÑADIR AL CARRITO
    // =====================
    
    const checkboxesCarrito = document.querySelectorAll('.carrito-checkbox');
    
    checkboxesCarrito.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.dataset.id;
            const nombre = this.dataset.nombre;
            const precio = parseFloat(this.dataset.precio);
            const imagen = this.dataset.imagen;
            
            if (this.checked) {
                // Añadir al carrito
                añadirAlCarrito(id, nombre, precio, imagen);
            } else {
                // Quitar del carrito
                quitarDelCarrito(id);
            }
        });
    });

    // Función para añadir producto al carrito (localStorage)
    function añadirAlCarrito(id, nombre, precio, imagen) {
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        
        // Verificar si ya existe
        const existe = carrito.find(item => item.id == id);
        
        if (existe) {
            existe.cantidad++;
        } else {
            carrito.push({
                id: id,
                nombre: nombre,
                precio: precio,
                imagen: imagen,
                cantidad: 1
            });
        }
        
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarContadorCarrito();
    }

    // Función para quitar producto del carrito
    function quitarDelCarrito(id) {
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        carrito = carrito.filter(item => item.id != id);
        localStorage.setItem('carrito', JSON.stringify(carrito));
        actualizarContadorCarrito();
    }

    // Función para actualizar el contador del carrito en el navbar
    function actualizarContadorCarrito() {
        const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
        const total = carrito.reduce((acc, item) => acc + item.cantidad, 0);
        
        const contadores = document.querySelectorAll('#contador-carrito, #contador-carrito-menu');
        contadores.forEach(contador => {
            if (contador) {
                contador.textContent = total;
            }
        });
    }

    // Actualizar contador al cargar la página
    actualizarContadorCarrito();

});

// Animación CSS para fadeIn
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .filtros-categorias.collapsed {
        display: none;
    }
`;
document.head.appendChild(style);
