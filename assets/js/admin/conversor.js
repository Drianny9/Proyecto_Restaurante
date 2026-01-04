//====CONVERSOR DE MONEDA====

// API de conversión (frankfurter.dev)

//Variables para guardar la moneda actual
let monedaActual = 'EUR';
let tasasDeCambio = {'EUR':1};

document.addEventListener('DOMContentLoaded', () =>{
    inicializarConversor();
});

function inicializarConversor() {
    //Llamamos a la API
    fetch('https://api.frankfurter.dev/v1/latest?from=EUR&to=USD')
        .then(function(respuesta){
            return respuesta.json();
        }) 
        .then(function(datosLimpios){
            Object.assign(tasasDeCambio, datosLimpios.rates); //.rates es donde tiene la lista de monedas la api
            console.log("Tasas cargadas y guardadas: ", tasasDeCambio);
        })
        .catch((error) => console.error("Error al conectar con la API: ", error));
}


