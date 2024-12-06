# Usamos una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:7.4-fpm

# Instalamos las dependencias necesarias para Laravel y Apache
RUN apt-get update -y && apt-get upgrade -y && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    libxml2-dev \
    apache2 \
    libapache2-mod-fcgid \
    libapache2-mod-headers \
    libapache2-mod-rewrite \
    libapache2-mod-ssl \
    libapache2-mod-deflate \
    libapache2-mod-expires \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql soap opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos Composer (para manejar las dependencias de Laravel)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitamos mod_rewrite de Apache, que es necesario para Laravel
RUN a2enmod rewrite

# Copiamos el archivo de configuración de Apache (si tienes uno específico)
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Definimos el directorio de trabajo
WORKDIR /var/www

# Copiamos todos los archivos del proyecto al contenedor
COPY . .

# Instalamos las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# Configuramos permisos para storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Exponemos el puerto 80 para que Render pueda acceder a la aplicación
EXPOSE 80

# Comando para iniciar Apache (Render manejará la ejecución de servicios)
CMD ["apache2ctl", "-D", "FOREGROUND"]
