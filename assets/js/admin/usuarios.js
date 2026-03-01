//========================================
//MODULO DE USUARIOS - Panel Admin (Clase)
//========================================

class UsuarioAdmin {
    constructor() {
        this.usuarios = [];
    }

    //========CARGAR USUARIOS========
    async cargar() {
        try {
            const response = await fetch('api/usuarios.php');
            const data = await response.json();

            if (data.estado === 'Exito') {
                this.usuarios = data.data;
                this.mostrar(this.usuarios);
            } else {
                console.error('Error al cargar usuarios:', data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========MOSTRAR USUARIOS EN LA TABLA========
    //Usa forEach para recorrer y renderizar cada usuario
    mostrar(usuarios) {
        const tabla = document.getElementById('tabla-usuarios');
        if (!tabla) return;

        tabla.innerHTML = '';

        if (usuarios.length === 0) {
            tabla.innerHTML = '<tr><td colspan="6" class="text-center">No hay usuarios</td></tr>';
            return;
        }

        //forEach para recorrer y renderizar cada usuario
        usuarios.forEach(usuario => {
            const rolClass = usuario.rol === 'admin' ? 'badge bg-danger' : 'badge bg-secondary';
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${usuario.id_usuario}</td>
                <td>${usuario.nombre}</td>
                <td>${usuario.email}</td>
                <td><span class="${rolClass}">${usuario.rol}</span></td>
                <td>${usuario.telefono || '-'}</td>
                <td class="acciones-btns">
                    <button class="btn btn-sm btn-warning btn-editar-usuario" data-id="${usuario.id_usuario}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-eliminar-usuario" data-id="${usuario.id_usuario}">
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
        document.querySelectorAll('.btn-editar-usuario').forEach(btn => {
            btn.addEventListener('click', () => this.editar(btn.dataset.id));
        });

        document.querySelectorAll('.btn-eliminar-usuario').forEach(btn => {
            btn.addEventListener('click', () => this.eliminar(btn.dataset.id));
        });
    }

    //========ABRIR MODAL PARA NUEVO USUARIO========
    abrirModalNuevo() {
        document.getElementById('modalUsuarioTitulo').textContent = 'Nuevo Usuario';
        document.getElementById('formUsuario').reset();
        document.getElementById('usuario-id').value = '';
        document.getElementById('campo-password').style.display = 'block';
        document.getElementById('usuario-password').required = true;

        const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
        modal.show();
    }

    //========EDITAR USUARIO EXISTENTE========
    async editar(id) {
        try {
            const response = await fetch('api/usuarios.php?id=' + id);
            const data = await response.json();

            if (data.estado === 'Exito') {
                const usuario = data.data;
                document.getElementById('modalUsuarioTitulo').textContent = 'Editar Usuario';
                document.getElementById('usuario-id').value = usuario.id_usuario;
                document.getElementById('usuario-nombre').value = usuario.nombre;
                document.getElementById('usuario-email').value = usuario.email;
                document.getElementById('usuario-telefono').value = usuario.telefono || '';
                document.getElementById('usuario-direccion').value = usuario.direccion || '';
                document.getElementById('usuario-rol').value = usuario.rol;
                document.getElementById('campo-password').style.display = 'none';
                document.getElementById('usuario-password').required = false;

                const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
                modal.show();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========GUARDAR USUARIO (CREAR O ACTUALIZAR)========
    async guardar() {
        const id = document.getElementById('usuario-id').value;
        const datos = {
            nombre: document.getElementById('usuario-nombre').value,
            email: document.getElementById('usuario-email').value,
            direccion: document.getElementById('usuario-direccion').value,
            telefono: document.getElementById('usuario-telefono').value,
            rol: document.getElementById('usuario-rol').value
        };

        try {
            let response;
            if (id) {
                //Actualizar - spread (...) para añadir id al objeto de datos
                response = await fetch('api/usuarios.php', {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ...datos, id_usuario: parseInt(id) })
                });
            } else {
                //Crear nuevo - spread (...) para añadir password
                const password = document.getElementById('usuario-password').value;
                response = await fetch('api/usuarios.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ...datos, password })
                });
            }

            const data = await response.json();

            if (data.estado === 'Exito') {
                bootstrap.Modal.getInstance(document.getElementById('modalUsuario')).hide();
                await this.cargar();
            } else {
                alert('Error: ' + data.mensaje);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    //========ELIMINAR USUARIO========
    async eliminar(id) {
        if (!confirm('¿Estás seguro de que quieres eliminar este usuario?')) return;

        try {
            const response = await fetch(`api/usuarios.php?id=${id}`, {
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

    //========INICIALIZAR EVENTOS DE USUARIOS========
    init() {
        const btnNuevo = document.getElementById('btn-nuevo-usuario');
        if (btnNuevo) {
            btnNuevo.addEventListener('click', () => this.abrirModalNuevo());
        }

        const btnGuardar = document.getElementById('btn-guardar-usuario');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', () => this.guardar());
        }

        //Cargar usuarios al inicio
        this.cargar();
    }
}

//====INSTANCIA GLOBAL====
const usuarioAdmin = new UsuarioAdmin();

//====FUNCIONES WRAPPER GLOBALES====
//Para mantener compatibilidad con inicializacion.js y otros scripts
function cargarUsuarios() { usuarioAdmin.cargar(); }
function mostrarUsuarios(usuarios) { usuarioAdmin.mostrar(usuarios); }
function abrirModalNuevoUsuario() { usuarioAdmin.abrirModalNuevo(); }
function editarUsuario(id) { usuarioAdmin.editar(id); }
function guardarUsuario() { usuarioAdmin.guardar(); }
function eliminarUsuario(id) { usuarioAdmin.eliminar(id); }
function inicializarUsuarios() { usuarioAdmin.init(); }
