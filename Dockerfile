FROM php:7.4-apache

# Instalamos las dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql soap opcache \
    && apt-get clean

# Habilitamos mod_rewrite para Laravel
RUN a2enmod rewrite

# Copiamos el archivo de configuración de Apache
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Definimos el directorio de trabajo
WORKDIR /var/www

# Copiamos todos los archivos del proyecto al contenedor
COPY . .

# Instalamos las dependencias de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --optimize-autoloader --no-dev

# Configuramos permisos para los directorios storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Exponemos el puerto 80 para que Render pueda acceder a la aplicación
EXPOSE 80

# Comando para iniciar Apache y PHP-FPM
CMD ["apache2ctl", "-D", "FOREGROUND"]
