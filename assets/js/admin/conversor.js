//====CONVERSOR DE MONEDA====

// API de conversión (frankfurter.dev)

//Variables para guardar la moneda actual
let monedaActual = 'EUR';
let tasasDeCambio = { 'EUR': 1 };

document.addEventListener('DOMContentLoaded', () => {
    inicializarConversor();
});

function inicializarConversor() {
    //Llamamos a la API
    fetch('https://api.frankfurter.dev/v1/latest?from=EUR&to=USD')
        .then((respuesta) => respuesta.json())
        .then((datosLimpios) => {
            //Object.assign(DESTINO, ORIGEN)
            Object.assign(tasasDeCambio, datosLimpios.rates); //.rates es donde tiene la lista de monedas la api
        })
        .catch((error) => console.error("Error al conectar con la API: ", error));

    //Detectar clicks en las opciones de menú
    const opcionesMoneda = document.querySelectorAll('.dropdown-item[data-moneda]');
    opcionesMoneda.forEach((opcion) => {
        opcion.addEventListener('click', (e) => {
            e.preventDefault();//Evita que el enlace recargue o la página suba

            const nuevaMoneda = e.target.getAttribute('data-moneda');
            cambiarMonedaGlobal(nuevaMoneda);//cambiarMoneda() es la función para el visual
        });
    });
}

//====CAMBIO VISUAL DE MONEDA====
function cambiarMonedaGlobal(moneda) {
    monedaActual = moneda;
    const tasa = tasasDeCambio[moneda];

    // Definir símbolo
    let simbolo;

    if (moneda === 'EUR') {
        simbolo = '€';
    } else {
        simbolo = '$';
    }

    // 1. Actualizar textos de los botones Dropdown para saber qué está seleccionado
    const botonesDropdown = document.querySelectorAll('.dropdown-toggle');
    botonesDropdown.forEach(btn => {
        btn.innerHTML = `<i class="bi bi-currency-exchange"></i> ${moneda}`;
    });

    // 2. Actualizar precios en las tablas
    const celdasPrecio = document.querySelectorAll('.precio-display');

    celdasPrecio.forEach(celda => {
        // Leemos el precio base en EUROS guardado en el atributo data
        const precioBase = parseFloat(celda.getAttribute('data-precio-base'));

        //NaN (not a number)
        if (!isNaN(precioBase) && tasa) {
            const precioFinal = (precioBase * tasa).toFixed(2);
            celda.innerText = `${precioFinal} ${simbolo}`;
        }
    });
}

//====REAPLICAR MONEDA ACTUAL====
// Función global para que otros scripts puedan llamarla cuando cargan datos nuevos
// window es palabra reservada(es la pestaña del navegador)
window.aplicarMonedaActual = () => {
    if (monedaActual !== 'EUR') {
        cambiarMonedaGlobal(monedaActual);
    }
};



