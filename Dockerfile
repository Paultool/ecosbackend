# Usa la imagen oficial de PHP como base
FROM php:8.1-fpm

# Establecer el directorio de trabajo
WORKDIR /var/www

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el contenido del proyecto al contenedor
COPY . .

# Establecer permisos
RUN chown -R www-data:www-data /var/www

# Instalar dependencias de PHP
RUN composer install

# Exponer el puerto 9000 y ejecutar PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
