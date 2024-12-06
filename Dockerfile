# Usa una imagen base con PHP 7.4 y Nginx
FROM php:7.4-fpm

# Instalamos las extensiones necesarias para Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Instalamos Nginx
RUN apt-get update && apt-get install -y nginx

# Establecemos el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de tu aplicación al contenedor
COPY . .

# Instalamos las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Copia la configuración de Nginx (ver abajo)
COPY nginx/default.conf /etc/nginx/conf.d/

# Exponemos el puerto 80
EXPOSE 80

# Iniciamos Nginx y PHP-FPM en el mismo contenedor
CMD service nginx start && php-fpm
