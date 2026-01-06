// ========================================
// MODULO DE USUARIOS - Panel Admin
// ========================================

// Cargar usuarios en la tabla
function cargarUsuarios() {
    fetch('api/usuarios.php')
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                mostrarUsuarios(data.data);
            } else {
                console.error('Error al cargar usuarios:', data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
}

// Mostrar usuarios en la tabla
function mostrarUsuarios(usuarios) {
    const tabla = document.getElementById('tabla-usuarios');
    if (!tabla) return;
    
    tabla.innerHTML = '';
    
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
                <button class="btn btn-sm btn-warning" onclick="editarUsuario(${usuario.id_usuario})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${usuario.id_usuario})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;
        tabla.appendChild(tr);
    });
}

// Abrir modal para nuevo usuario
function abrirModalNuevoUsuario() {
    document.getElementById('modalUsuarioTitulo').textContent = 'Nuevo Usuario';
    document.getElementById('formUsuario').reset();
    document.getElementById('usuario-id').value = '';
    document.getElementById('campo-password').style.display = 'block';
    document.getElementById('usuario-password').required = true;
    
    const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));
    modal.show();
}

// Editar usuario existente
function editarUsuario(id) {
    fetch('api/usuarios.php?id=' + id)
        .then(response => response.json())
        .then(data => {
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
        })
        .catch(error => console.error('Error:', error));
}

// Guardar usuario (crear o actualizar)
function guardarUsuario() {
    const id = document.getElementById('usuario-id').value;
    const datos = {
        nombre: document.getElementById('usuario-nombre').value,
        email: document.getElementById('usuario-email').value,
        direccion: document.getElementById('usuario-direccion').value,
        telefono: document.getElementById('usuario-telefono').value,
        rol: document.getElementById('usuario-rol').value
    };
    
    if (id) {
        // Actualizar
        datos.id_usuario = parseInt(id);
        fetch('api/usuarios.php', {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                bootstrap.Modal.getInstance(document.getElementById('modalUsuario')).hide();
                cargarUsuarios();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        // Crear nuevo
        datos.password = document.getElementById('usuario-password').value;
        fetch('api/usuarios.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(datos)
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                bootstrap.Modal.getInstance(document.getElementById('modalUsuario')).hide();
                cargarUsuarios();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Eliminar usuario
function eliminarUsuario(id) {
    if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
        fetch(`api/usuarios.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.estado === 'Exito') {
                cargarUsuarios();
            } else {
                alert('Error: ' + data.mensaje);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Inicializar eventos de usuarios
function inicializarUsuarios() {
    const btnNuevo = document.getElementById('btn-nuevo-usuario');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', abrirModalNuevoUsuario);
    }
    
    const btnGuardar = document.getElementById('btn-guardar-usuario');
    if (btnGuardar) {
        btnGuardar.addEventListener('click', guardarUsuario);
    }
    
    // Cargar usuarios al inicio
    cargarUsuarios();
}
