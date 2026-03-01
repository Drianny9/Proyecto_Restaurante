//========================================
//MODULO DE LOGS - Panel Admin (Clase)
//========================================

class LogAdmin {
    constructor() {
        this.logs = [];
    }

    //========CARGAR LOGS========
    async cargar() {
        try {
            const response = await fetch('api/logs.php');
            const data = await response.json();

            if (data.estado === 'Exito') {
                this.logs = data.data;
                this.mostrar(this.logs);
            } else {
                console.error('Error al cargar logs:', data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========MOSTRAR LOGS EN LA TABLA========
    //Usa forEach para recorrer y renderizar cada log
    mostrar(logs) {
        const tabla = document.getElementById('tabla-logs');
        if (!tabla) return;

        tabla.innerHTML = '';

        if (!logs || logs.length === 0) {
            tabla.innerHTML = '<tr><td colspan="4" class="text-center">No hay registros de logs</td></tr>';
            return;
        }

        //forEach para recorrer y renderizar cada log
        logs.forEach(log => {
            const fecha = new Date(log.fecha_hora).toLocaleString('es-ES');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${log.id_log}</td>
                <td>${log.accion}</td>
                <td>${fecha}</td>
                <td class="acciones-btns">
                    <button class="btn btn-sm btn-danger btn-eliminar-log" data-id="${log.id_log}" title="Eliminar">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tabla.appendChild(tr);
        });

        //Configurar eventos de botones después de renderizar
        this.configurarBotones();
    }

    //========CONFIGURAR EVENTOS DE BOTONES========
    //Usa forEach para asignar eventos a todos los botones
    configurarBotones() {
        document.querySelectorAll('.btn-eliminar-log').forEach(btn => {
            btn.addEventListener('click', () => this.eliminar(btn.dataset.id));
        });
    }

    //========ELIMINAR UN LOG ESPECÍFICO========
    async eliminar(id) {
        if (!confirm('¿Eliminar este registro?')) return;

        try {
            const response = await fetch(`api/logs.php?id=${id}`, {
                method: 'DELETE'
            });
            const data = await response.json();

            if (data.estado === 'Exito') {
                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========LIMPIAR TODOS LOS LOGS========
    //Usa Promise.all + map para eliminar todos en paralelo
    async limpiarTodos() {
        if (!confirm('¿Estás seguro de que quieres eliminar TODOS los logs? Esta acción no se puede deshacer.')) return;

        if (!this.logs || this.logs.length === 0) {
            alert('No hay logs para eliminar');
            return;
        }

        try {
            //Promise.all + map para paralelizar todas las eliminaciones
            await Promise.all(
                this.logs.map(log =>
                    fetch(`api/logs.php?id=${log.id_log}`, { method: 'DELETE' })
                )
            );
            await this.cargar();
        } catch (error) {
            console.error('Error:', error);
            alert('Error al limpiar logs');
        }
    }

    //========INICIALIZAR EVENTOS DE LOGS========
    init() {
        const btnLimpiar = document.getElementById('btn-limpiar-logs');
        if (btnLimpiar) {
            btnLimpiar.addEventListener('click', () => this.limpiarTodos());
        }

        //Cargar logs al inicio
        this.cargar();
    }
}

//====INSTANCIA GLOBAL====
const logAdmin = new LogAdmin();

//====FUNCIONES WRAPPER GLOBALES====
//Para mantener compatibilidad con inicializacion.js y otros scripts
function cargarLogs() { logAdmin.cargar(); }
function mostrarLogs(logs) { logAdmin.mostrar(logs); }
function eliminarLog(id) { logAdmin.eliminar(id); }
function limpiarTodosLogs() { logAdmin.limpiarTodos(); }
function inicializarLogs() { logAdmin.init(); }
