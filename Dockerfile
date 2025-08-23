# Stage 1: Builder - instalar dependencias y construir aplicación
FROM php:8.2-cli AS builder

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    unzip \
    libonig-dev \
    libzip-dev \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copiar composer
COPY composer.json composer.lock* ./

# Instalar dependencias
RUN composer install --no-dev --no-autoloader --no-scripts --prefer-dist --no-interaction

# Copiar el resto del código
COPY . .

# Optimizar autoloader
RUN composer dump-autoload --optimize

# Stage 2: Producción - imagen final con Apache
FROM php:8.2-apache

# Instalar extensiones
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurar Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Copiar aplicación
COPY --from=builder /var/www/html /var/www/html

# Crear directorios para cache y logs con permisos
RUN mkdir -p /tmp/cache /tmp/log \
    && chmod -R 777 /tmp/cache /tmp/log \
    && chown -R www-data:www-data /var/www/html

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar OPcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 80

COPY start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/start.sh
CMD ["start.sh"]