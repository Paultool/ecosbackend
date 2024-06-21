FROM php:7.4-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Instalar extensiones PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar el contenido del proyecto al contenedor
COPY . .

# Ejecutar Composer install
RUN composer install --no-dev --optimize-autoloader

# Copiar configuración de Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Establecer las variables de entorno
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Cambiar el directorio de Apache DocumentRoot
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

# Establecer los permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
