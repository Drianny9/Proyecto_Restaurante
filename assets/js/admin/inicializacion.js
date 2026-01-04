//====ADMIN INIT - Inicialización y navegación====

//Esperamos a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // Configurar navegación entre secciones
    configurarNavegacion();
    
    // Inicializar módulos
    if (typeof initProductos === 'function') {
        initProductos();
    }
    if (typeof initLineasPedido === 'function') {
        initLineasPedido();
    }
});

//=======NAVEGACIÓN ENTRE SECCIONES=========
function configurarNavegacion() {
    //Obtener botones
    const botonesMenu = document.querySelectorAll(".menu-btn");

    botonesMenu.forEach((boton) => {
        boton.addEventListener('click', function() {
            const seccionObjetivo = boton.getAttribute("data-target");

            //Ocultar todas las secciones
            document.querySelectorAll('.content-section').forEach((seccion) => {
                seccion.classList.remove('active-section');
            });

            //Quitar clase activa de los botones
            botonesMenu.forEach(btn => btn.classList.remove('active'));

            //Mostrar sección seleccionada (usuarios, productos, etc.)
            document.getElementById(seccionObjetivo).classList.add('active-section');
            this.classList.add('active');

            //Cargar datos correspondientes según la sección
            switch(seccionObjetivo) {
                case 'productos':
                    if (typeof cargarProductos === 'function') {
                        cargarProductos();
                    }
                    break;
                case 'lineas-pedido':
                    if (typeof cargarLineasPedido === 'function') {
                        cargarLineasPedido();
                    }
                    break;
                // Añadir más casos según se necesiten
            }
        });
    });
}
