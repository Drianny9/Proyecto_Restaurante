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

//Vaciar carrito
function vaciarCarrito(){
    localStorage.removeItem('carrito');
}

//Calcular total de precio
//Calcular total de productos que hay