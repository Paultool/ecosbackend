# Usa la imagen base oficial de PHP con Apache
FROM php:8.1-apache

# Actualiza los repositorios y instala las dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git

# Configura e instala las extensiones de PHP GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Instala las extensiones de PHP
RUN docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

# Copia el código de la aplicación al contenedor
COPY . /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Configura el propietario de los archivos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
