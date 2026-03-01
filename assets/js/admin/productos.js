//========================================
//MODULO DE PRODUCTOS - Panel Admin (Clase)
//========================================

class ProductoAdmin {
    constructor() {
        this.productos = [];
    }

    //METODOS QUE TENDRA EL OBJETO

    //========CARGAR PRODUCTOS========
    async cargar() {
        console.log('Cargando productos...');
        try {
            const response = await fetch('api/productos.php');
            const data = await response.json();
            console.log('Respuesta productos:', data);

            if (data.estado === 'Exito') {
                this.productos = data.data;
                this.mostrar(this.productos);
            } else {
                console.error('Error al cargar productos', data.mensaje);
            }
        } catch (error) {
            console.error('Error en la petición:', error);
        }
    }

    //========MOSTRAR PRODUCTOS EN LA TABLA========
    //Usa forEach + cloneNode para renderizar
    mostrar(productos) {
        const tbody = document.getElementById('tabla-productos');
        const template = document.getElementById('template-fila-producto');
        if (!tbody || !template) return;

        tbody.innerHTML = '';

        if (productos.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No hay productos</td></tr>';
            return;
        }

        //forEach para recorrer y renderizar cada producto
        productos.forEach(producto => {
            //Clonar el template para tener la misma estructura
            const clone = template.content.cloneNode(true); //true lo copia tal cual, false copia la cascara pero no lo de dentro

            //Rellenar datos
            clone.querySelector('.producto-id').textContent = producto.id_producto;
            clone.querySelector('.producto-nombre').textContent = producto.nombre;
            clone.querySelector('.producto-descripcion').textContent = producto.descripcion;

            const precioCell = clone.querySelector('.precio-display');
            precioCell.dataset.precioBase = producto.precio_base;
            precioCell.textContent = `${Number(producto.precio_base).toFixed(2)} €`;

            clone.querySelector('.producto-imagen').textContent = producto.imagen || '-';

            //Configurar botones con data-id
            clone.querySelector('.btn-editar-producto').dataset.id = producto.id_producto;
            clone.querySelector('.btn-eliminar-producto').dataset.id = producto.id_producto;

            tbody.appendChild(clone);
        });

        this.configurarBotones();

        //Reaplicar moneda si el usuario ya había seleccionado otra
        if (window.aplicarMonedaActual) {
            window.aplicarMonedaActual();
        }
    }

    //========CONFIGURAR BOTONES DE PRODUCTOS========
    //Usa forEach para asignar eventos a todos los botones
    configurarBotones() {
        //Botones editar
        document.querySelectorAll('.btn-editar-producto').forEach(boton => {
            boton.addEventListener('click', () => {
                const id = boton.getAttribute('data-id');
                this.abrirModalEditar(id);
            });
        });

        //Botones eliminar
        document.querySelectorAll('.btn-eliminar-producto').forEach(boton => {
            boton.addEventListener('click', () => {
                const id = boton.getAttribute('data-id');
                this.eliminar(id);
            });
        });
    }

    //========ELIMINAR PRODUCTO========
    async eliminar(id) {
        //Preguntamos si se esta seguro de eliminar
        if (!confirm('¿Estas seguro de eliminar este producto?')) {
            //Si cancela no hace nada
            return;
        }

        try {
            //LLamamos al metodo DELETE de la API con una petición HTTP
            const response = await fetch('api/productos.php', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' }, //Indicamos que se envia JSON
                body: JSON.stringify({ id: id }) /*enviamos el ID del producto. 
                                                  stringify convierte el JSON en string para que PHP lo pueda leer*/
            });
            const data = await response.json(); //Convertir respuesta a JSON

            if (data.estado === 'Exito') {
                alert(data.mensaje);
                await this.cargar(); //Actualizamos la tabla productos
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al eliminar producto');
        }
    }

    //========ABRIR MODAL PARA NUEVO PRODUCTO========
    abrirModalNuevo() {
        //Limpiar formulario
        document.getElementById('formProducto').reset();
        document.getElementById('producto-id').value = '';

        //Cambiar titulo
        document.getElementById('modalProductoTitulo').textContent = 'Nuevo Producto';

        //Abrir modal
        const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
        modal.show();
    }

    //========ABRIR MODAL PARA EDITAR PRODUCTO========
    async abrirModalEditar(id) {
        try {
            //Obtener datos del producto
            const response = await fetch('api/productos.php?id=' + id);
            const data = await response.json();

            if (data.estado === 'Exito') {
                const producto = data.data;

                //Rellenar formulario
                document.getElementById('producto-id').value = producto.id_producto;
                document.getElementById('producto-nombre').value = producto.nombre;
                document.getElementById('producto-descripcion').value = producto.descripcion || '';
                document.getElementById('producto-categoria').value = producto.id_categoria;
                document.getElementById('producto-precio').value = producto.precio_base;
                document.getElementById('producto-imagen').value = producto.imagen || '';

                //Cambiar titulo
                document.getElementById('modalProductoTitulo').textContent = 'Editar Producto';

                //Abrir modal
                const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
                modal.show();
            } else {
                alert('Error al cargar producto');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al cargar producto');
        }
    }

    //========GUARDAR PRODUCTO (CREAR O ACTUALIZAR)========
    async guardar() {
        const id = document.getElementById('producto-id').value;
        const nombre = document.getElementById('producto-nombre').value;
        const descripcion = document.getElementById('producto-descripcion').value;
        const id_categoria = document.getElementById('producto-categoria').value;
        const precio_base = document.getElementById('producto-precio').value;
        const imagen = document.getElementById('producto-imagen').value;

        //Validar campos requeridos
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
            //Si hay ID, es una actualización - spread para añadir id
            metodo = 'PUT';
            datos.id = parseInt(id);
        }

        try {
            const response = await fetch('api/productos.php', {
                method: metodo,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            });
            const data = await response.json();

            if (data.estado === 'Exito') {
                alert(data.mensaje);

                //Cerrar modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalProducto'));
                modal.hide();

                //Recargar tabla
                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al guardar producto');
        }
    }

    //========INICIALIZACIÓN DE PRODUCTOS========
    init() {
        const btnNuevo = document.getElementById('btn-nuevo-producto');
        if (btnNuevo) {
            btnNuevo.addEventListener('click', () => this.abrirModalNuevo());
        }

        //Configurar boton guardar del modal
        const btnGuardar = document.getElementById('btn-guardar-producto');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => this.guardar());
        }

        //Cargar productos al inicio
        this.cargar();
    }
}

//====INSTANCIA GLOBAL====
const productoAdmin = new ProductoAdmin(); //Aqui es donde se ejecuta el constructor

//====FUNCIONES WRAPPER GLOBALES====
//Para mantener compatibilidad con inicializacion.js y otros scripts
function initProductos() { productoAdmin.init(); }
function cargarProductos() { productoAdmin.cargar(); }
function mostrarProductos(productos) { productoAdmin.mostrar(productos); }
