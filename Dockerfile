# Usa una imagen base con PHP 7.4 y Nginx
FROM php:7.4-fpm

# Instalamos las dependencias necesarias para las extensiones
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    libmcrypt-dev \
    libzip-dev \
    curl \
    git \
    unzip \
    && apt-get clean

# Instalamos las extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql mbstring bcmath zip

# Instalamos Nginx
RUN apt-get install -y nginx

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de tu aplicación al contenedor
COPY . .

# Instalamos Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Verificamos versiones de PHP y Composer
RUN php -v
RUN composer --version

# Instalamos las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Copia la configuración de Nginx
COPY nginx/default.conf /etc/nginx/conf.d/

# Cambiamos permisos para evitar problemas con Composer
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Exponemos el puerto 80
EXPOSE 80

# Iniciamos Nginx y PHP-FPM en el mismo contenedor
CMD service nginx start && php-fpm
