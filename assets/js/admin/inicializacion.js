//========================================
//ADMIN INIT - Inicialización y navegación (Clase)
//========================================

class AdminInit {
    constructor() {
        this.secciones = [];
    }

    //========INICIAR TODOS LOS MÓDULOS========
    iniciar() {
        this.configurarNavegacion();

        //Inicializar cada módulo si existe la instancia global
        if (typeof productoAdmin !== 'undefined') {
            productoAdmin.init();
        }
        if (typeof lineaPedidoAdmin !== 'undefined') {
            lineaPedidoAdmin.init();
        }
        if (typeof usuarioAdmin !== 'undefined') {
            usuarioAdmin.init();
        }
        if (typeof pedidoAdmin !== 'undefined') {
            pedidoAdmin.init();
        }
        if (typeof logAdmin !== 'undefined') {
            logAdmin.init();
        }
    }

    //=======NAVEGACIÓN ENTRE SECCIONES=========
    configurarNavegacion() {
        //Obtener botones
        const botonesMenu = document.querySelectorAll(".menu-btn");

        //forEach para recorrer todas las acciones al darle a un boton
        botonesMenu.forEach((boton) => {
            boton.addEventListener('click', () => {
                const seccionObjetivo = boton.getAttribute("data-target");

                //Ocultar todas las secciones con forEach
                document.querySelectorAll('.content-section').forEach((seccion) => {
                    seccion.classList.remove('active-section');
                });

                //Quitar clase activa de los botones con forEach
                botonesMenu.forEach(btn => btn.classList.remove('active'));

                //Mostrar sección seleccionada (usuarios, productos, etc.)
                document.getElementById(seccionObjetivo).classList.add('active-section');
                boton.classList.add('active');

                //Cargar datos correspondientes según la sección
                switch(seccionObjetivo) {
                    case 'productos':
                        if (typeof productoAdmin !== 'undefined') productoAdmin.cargar();
                        break;
                    case 'usuarios':
                        if (typeof usuarioAdmin !== 'undefined') usuarioAdmin.cargar();
                        break;
                    case 'pedidos':
                        if (typeof pedidoAdmin !== 'undefined') pedidoAdmin.cargar();
                        break;
                    case 'logs':
                        if (typeof logAdmin !== 'undefined') logAdmin.cargar();
                        break;
                    case 'lineas-pedido':
                        if (typeof lineaPedidoAdmin !== 'undefined') lineaPedidoAdmin.cargar();
                        break;
                }
            });
        });
    }
}

//====INSTANCIA GLOBAL====
const adminInit = new AdminInit();

//Esperamos a que el DOM esté cargado
document.addEventListener('DOMContentLoaded', () => {
    adminInit.iniciar();
});
