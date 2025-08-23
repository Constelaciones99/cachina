#!/bin/bash
set -e

# Crear directorios temporales
mkdir -p /tmp/cache /tmp/log
chmod -R 777 /tmp/cache /tmp/log

# Limpiar cache de Symfony
php bin/console cache:clear --env=prod --no-debug
php bin/console cache:warmup --env=prod

# Ejecutar Apache
apache2-foreground