#!/bin/bash
set -e

# Ajustar permisos (por si acaso)
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Crear directorios necesarios
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/bootstrap/cache

# Ejecutar comandos de Laravel para optimización
php artisan config:clear
php artisan cache:clear
php artisan optimize
php artisan config:cache

# Ejecutar migraciones si es necesario (solo en producción)
# php artisan migrate --force

# Iniciar Apache
apache2-foreground