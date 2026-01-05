document.addEventListener('DOMContentLoaded', function(){
    flatpickr("#fecha-reserva", { //Creamos el objeto
        locale: "es",          // Pone los dias en Español
        minDate: "today",      // Impide reservar en el pasado
        dateFormat: "Y-m-d",   // Formato para guardar en Base de Datos (2026-05-20)
        altInput: true,        // Muestra una fecha más bonita al usuario...
        altFormat: "l, j F, Y", // ...ej: "Lunes, 20 Mayo, 2024"
        allowInput: false,      //Impedimos escribir a mano
    });

    flatpickr("#hora-reserva", {
        enableTime: true,       // Activa modo reloj
        noCalendar: true,       // Apaga modo calendario
        dateFormat: "H:i",      // Formato 24h
        time_24hr: true,        // Sin AM/PM
        minTime: "13:00",       // Apertura
        maxTime: "23:00",       // Cierre
        allowInput: false,
        minuteIncrement: 15
    })
});

