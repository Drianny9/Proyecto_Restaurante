// ========================================
// MODULO DE LOGS - Panel Admin
// ========================================

// Cargar logs en la tabla
function cargarLogs() {
    fetch('api/logs.php')
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                mostrarLogs(data.data);
            } else {
                console.error('Error al cargar logs:', data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Mostrar logs en la tabla
function mostrarLogs(logs) {
    const tabla = document.getElementById('tabla-logs');
    if (!tabla) return;
    
    tabla.innerHTML = '';
    
    if (logs.length === 0) {
        tabla.innerHTML = '<tr><td colspan="4" class="text-center">No hay registros de logs</td></tr>';
        return;
    }
    
    logs.forEach(log => {
        const fecha = new Date(log.fecha_hora).toLocaleString('es-ES');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${log.id_log}</td>
            <td>${log.accion}</td>
            <td>${fecha}</td>
            <td class="acciones-btns">
                <button class="btn btn-sm btn-danger" onclick="eliminarLog(${log.id_log})" title="Eliminar">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tabla.appendChild(tr);
    });
}

// Eliminar un log específico
function eliminarLog(id) {
    if (confirm('¿Eliminar este registro?')) {
        fetch(`api/logs.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                cargarLogs();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Limpiar todos los logs (función para implementar en backend)
function limpiarTodosLogs() {
    if (confirm('¿Estás seguro de que quieres eliminar TODOS los logs? Esta acción no se puede deshacer.')) {
        // Por ahora eliminamos uno por uno los logs visibles
        const tabla = document.getElementById('tabla-logs');
        const filas = tabla.querySelectorAll('tr');
        
        if (filas.length === 0) {
            alert('No hay logs para eliminar');
            return;
        }
        
        // Nota: En producción, esto debería ser una llamada a un endpoint específico
        alert('Función de limpieza masiva no implementada. Elimina los logs individualmente.');
    }
}

// Inicializar eventos de logs
function inicializarLogs() {
    const btnLimpiar = document.getElementById('btn-limpiar-logs');
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', limpiarTodosLogs);
    }
    
    // Cargar logs al inicio
    cargarLogs();
}
