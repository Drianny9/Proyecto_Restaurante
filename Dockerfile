# Imagen base: PHP 8 con Apache
FROM php:8.2-apache

# Instalar extensión mysqli para conectar con MySQL
RUN docker-php-ext-install mysqli

# Habilitar mod_rewrite de Apache (para URLs amigables)
RUN a2enmod rewrite

# Copiar todo el proyecto al directorio de Apache
COPY . /var/www/html/

# Permisos correctos
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto 80
EXPOSE 80
