# Usamos una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:7.4-fpm

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
    && docker-php-ext-install gd pdo pdo_mysql soap opcache

# Instalamos Composer (para manejar las dependencias de Laravel)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definimos el directorio de trabajo donde se copiará el código
WORKDIR /var/www

# Copiamos los archivos del proyecto al contenedor
COPY . .

# Instalamos las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# Copiamos el archivo de entorno de Laravel al contenedor
COPY .env.example .env

# Generamos la clave de la aplicación Laravel (si no la tienes aún)
RUN php artisan key:generate

# Exponemos el puerto que utilizará el servidor web
EXPOSE 9000

# Comando para iniciar PHP-FPM (servidor de PHP)
CMD ["php-fpm"]

# Configuramos el directorio de trabajo dentro del contenedor
WORKDIR /var/www

# Usamos Nginx o Apache como servidor web si es necesario

