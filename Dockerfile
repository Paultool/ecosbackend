# Usa la imagen oficial de PHP como base
FROM php:8.1-fpm

# Establecer el directorio de trabajo
WORKDIR /var/www

# Actualizar y instalar dependencias del sistema
RUN apt-get update && \
    apt-get install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git

# Instalar las extensiones PHP una por una
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install zip

# Configurar y instalar GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el contenido del proyecto al contenedor
COPY . .

# Establecer permisos
RUN chown -R www-data:www-data /var/www

# Instalar dependencias de PHP
RUN composer install --no-dev --optimize-autoloader

# Copiar el archivo de configuración de PHP-FPM
COPY ./docker/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf

# Ejecutar migraciones y seeders
RUN php artisan migrate:fresh --seed

# Exponer el puerto 9000 y ejecutar PHP-FPM
EXPOSE 9000
CMD ["php-fpm"]
