# CUPRA EATS 🚘🍔 - Proyecto Final DAW

![PHP](https://img.shields.io/badge/PHP-8.0-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-Compose-2496ED?style=flat&logo=docker&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=flat&logo=bootstrap&logoColor=white)

## 📖 Descripción del Proyecto
**CUPRA EATS** es una aplicación web de restauración desarrollada en PHP nativo siguiendo el patrón de arquitectura **MVC (Modelo-Vista-Controlador)**.

El proyecto simula un e-commerce real permitiendo:
* **Gestión de Usuarios:** Registro, Login y roles (Cliente/Admin).
* **Catálogo Dinámico:** Productos cargados desde Base de Datos MySQL.
* **Carrito de Compra:** Persistencia mediante `localStorage` y API REST.
* **Panel de Administración:** Gestión de productos, pedidos y logs del sistema.

## 🌐 Despliegue (Demo Online)
El proyecto está desplegado y funcional en el servidor gratuito InfinityFree:

👉 **[Ver Demo: http://cupraeats.rf.gd](http://cupraeats.rf.gd)**

## 📂 Documentación y Memoria
Tal y como se solicita en los requisitos de entrega, la memoria técnica completa del proyecto se encuentra en la carpeta de documentación:

📄 **[Ver Memoria del Proyecto (PDF)](./documentacion/Memoria_CUPRA_EATS.pdf)**

## 🛠 Tecnologías Utilizadas
* **Backend:** PHP 8 (Nativo, sin frameworks).
* **Base de Datos:** MySQL.
* **Frontend:** HTML5, CSS3, Bootstrap 5.
* **Scripting:** JavaScript (Fetch API para el carrito y lógica asíncrona).
* **Infraestructura:** Docker & Docker Compose.

## ⚙️ Instalación y Puesta en Marcha

### Opción A: Despliegue con Docker (Recomendado)
Este proyecto incluye contenedorización completa.
1. Asegúrate de tener **Docker Desktop** instalado.
2. Abre una terminal en la raíz del proyecto.
3. Ejecuta el comando:
   ```bash
   docker compose up -d --build
4. Una vez carguen los contenedores, accede a:
    🌍 Web Principal: http://localhost:8080
    🗄️ Gestor Base de Datos (phpMyAdmin): http://localhost:8081