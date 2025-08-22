# Stage 1: Builder - instalar dependencias y construir aplicación
FROM php:8.2-cli AS builder

# Instalar dependencias del sistema necesarias para composer
RUN apt-get update && apt-get install -y \
    unzip \
    libonig-dev \
    libzip-dev \
    curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer directorio de trabajo igual al destino final de Apache
WORKDIR /var/www/html

# Copiar solo composer para aprovechar cache
COPY composer.json composer.lock* ./

# Instalar dependencias de PHP (sin autoloader ni scripts para acelerar)
RUN if [ -f "composer.lock" ]; then \
        composer install --no-dev --no-autoloader --no-scripts --prefer-dist --no-interaction; \
    else \
        composer install --no-dev --no-autoloader --no-scripts --prefer-dist --no-interaction; \
    fi

# Copiar el resto del código de la aplicación
COPY . .

# Optimizar autoloader
RUN composer dump-autoload --optimize

# Stage 2: Producción - imagen final con Apache
FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Evitar warning de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configurar document root a /var/www/html/public
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf

# Copiar archivos construidos desde el builder
COPY --from=builder /var/www/html /var/www/html

# Asegurar que exista la carpeta public (si tu proyecto no la incluye por algún motivo)
RUN mkdir -p /var/www/html/public

# Crear directorios Laravel típicos y fijar permisos adecuados para Apache
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar OPcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/opcache.ini

EXPOSE 80