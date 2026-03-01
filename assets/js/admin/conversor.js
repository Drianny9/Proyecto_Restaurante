//====CONVERSOR DE MONEDA (Clase)====
//Usa la API de frankfurter.dev para convertir precios

class ConversorMoneda {
    constructor() {
        this.monedaActual = 'EUR';
        this.tasasDeCambio = { 'EUR': 1 };
        this.simbolos = { 'EUR': '€', 'USD': '$' };
    }

    //========INICIALIZAR: CARGAR TASAS Y CONFIGURAR EVENTOS========
    async init() {
        //Llamamos a la API de conversión
        try {
            const respuesta = await fetch('https://api.frankfurter.dev/v1/latest?from=EUR&to=USD');
            const datosLimpios = await respuesta.json();
            //Object.assign(DESTINO, ORIGEN) - copia las tasas de la API al objeto
            Object.assign(this.tasasDeCambio, datosLimpios.rates); //.rates es donde tiene la lista de monedas la api
        } catch (error) {
            console.error("Error al conectar con la API: ", error);
        }

        //Detectar clicks en las opciones de menú - usa forEach
        document.querySelectorAll('.dropdown-item[data-moneda]').forEach(opcion => {
            opcion.addEventListener('click', (e) => {
                e.preventDefault(); //Evita que el enlace recargue o la página suba
                const nuevaMoneda = e.target.getAttribute('data-moneda');
                this.cambiar(nuevaMoneda);
            });
        });
    }

    //====CAMBIO VISUAL DE MONEDA====
    //Usa forEach para actualizar todos los elementos de precio
    cambiar(moneda) {
        this.monedaActual = moneda;
        const tasa = this.tasasDeCambio[moneda]; //Aplicamos el equivalente de la moneda que queremos usar
        const simbolo = this.simbolos[moneda] || moneda;

        //1. Actualizar textos de los botones Dropdown para saber qué está seleccionado - usa forEach
        document.querySelectorAll('.dropdown-toggle').forEach(btn => {
            btn.innerHTML = `<i class="bi bi-currency-exchange"></i> ${moneda}`;
        });

        //2. Actualizar precios en las tablas - usa forEach
        document.querySelectorAll('.precio-display').forEach(celda => {
            //Leemos el precio base en EUROS guardado en el atributo data
            const precioBase = parseFloat(celda.getAttribute('data-precio-base'));

            //NaN (not a number)
            if (!isNaN(precioBase) && tasa) {
                const precioFinal = (precioBase * tasa).toFixed(2); //Fijamos a dos decimales
                celda.innerText = `${precioFinal} ${simbolo}`;
            }
        });
    }

    //====REAPLICAR MONEDA ACTUAL====
    //Para cuando se cargan datos nuevos en tablas
    reaplicar() {
        if (this.monedaActual !== 'EUR') {
            this.cambiar(this.monedaActual);
        }
    }
}

//====INSTANCIA GLOBAL====
const conversor = new ConversorMoneda();

//Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    conversor.init();
});

//====FUNCIÓN GLOBAL====
//Para que otros scripts puedan llamarla cuando cargan datos nuevos
//window es palabra reservada (es la pestaña del navegador)
window.aplicarMonedaActual = () => {
    conversor.reaplicar();
};