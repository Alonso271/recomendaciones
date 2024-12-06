# Usamos una imagen base de PHP con FPM (FastCGI Process Manager)
FROM php:7.4-fpm

# Instalamos las dependencias necesarias para Laravel y Nginx
RUN apt-get update -y && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    libxml2-dev \
    curl \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql soap opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalamos Composer (para manejar las dependencias de Laravel)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalamos Node.js y npm (usando la versión 12.x compatible con Laravel 5.6)
RUN curl -fsSL https://deb.nodesource.com/setup_12.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Definimos el directorio de trabajo
WORKDIR /var/www

# Copiamos todos los archivos del proyecto al contenedor
COPY . .

# Instalamos las dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# Limpiar el caché de npm y luego instalar las dependencias de npm y compilamos los activos frontend
RUN npm cache clean --force && npm install --legacy-peer-deps && npm run prod

# Configuramos permisos para storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Copiamos el archivo de configuración de Nginx
COPY nginx/default.conf /etc/nginx/sites-available/default

# Enlazamos el archivo de configuración de Nginx
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default && \
    rm -rf /etc/nginx/sites-enabled/default

# Exponemos el puerto 80 para servir la aplicación
EXPOSE 80

# Comando para iniciar Nginx y PHP-FPM
CMD ["sh", "-c", "nginx -g 'daemon off;' & php-fpm"]
