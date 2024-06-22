# Usa la imagen oficial de PHP como base
FROM php:8.1.10-cli

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
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el contenido del proyecto al contenedor
COPY . .

# Establecer permisos
RUN chown -R www-data:www-data /var/www

# Instalar dependencias de PHP
RUN composer install

# Ejecutar migraciones y seeders
RUN php artisan migrate:fresh --seed || true

# Exponer el puerto 9000 y ejecutar PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
